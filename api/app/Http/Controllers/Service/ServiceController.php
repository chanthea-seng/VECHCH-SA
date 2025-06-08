<?php

namespace App\Http\Controllers\Service;

// use
use App\Models\Service;
use App\Models\SubService;
use App\Models\ServiceImage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Service\ServiceCardResource;
use App\Http\Resources\Service\ServiceFullResource;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index(Request $req)
    {
        $req->validate([
            'search' => ['nullable', 'string', 'min:1', 'max:250'],
            'service_type' => ['nullable', 'integer', 'min:1', 'max:2'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sdir' => ['nullable', 'string', 'in:desc,asc'],
            'scol' => ['nullable', 'string', 'min:0', 'in:created_at,id,local_name,name'],
        ]);
        $per_page = $req->filled('per_page') ? $req->input('per_page') : 50;
        $sdir = $req->filled('sdir') ? $req->input('sdir') : 'desc';
        $scol = $req->filled('scol') ? $req->input('scol') : 'id';

        $services = new Service();
        if ($req->filled('search')) {
            $search = $req->input('search');
            $services = $services->where(function ($x) use ($search) {
                $x->whereHas('subServices', function ($y) use ($search) {
                    $y->where('local_description', 'like', "%" . $search . "%")
                        ->orWhere('description', 'like', "%" . $search . "%");
                })
                    ->orWhere('name', 'like', "%" . $search . "%")
                    ->orWhere('local_name', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%")
                    ->orWhere('local_description', 'like', "%" . $search . "%");
            });
        }

        if ($req->filled('service_type')) {
            $service_type = $req->input('service_type');
            $services = $services->where('service_type', $service_type);
        }

        $services = $services->withCount('subServices')
            ->with(['subServices', 'serviceImages'])
            ->orderBy($scol, $sdir);

        $services = $services->paginate($per_page);
        return $this->res_paginate('get success', ServiceCardResource::collection($services), $services);
    }
    public function find(Request $req, $id)
    {
        $req->merge(['id' => $id]);
        $req->validate(['id' => ['required', 'integer', 'min:1', 'exists:services,id']]);

        $service = new Service();
        $service = $service
            ->with(['subServices', 'serviceImages'])
            ->where('id', $id)
            ->first();
        return $this->res_success('get success', new ServiceFullResource($service));
    }
    public function store(Request $req)
    {
        $sub_services = json_decode($req->input('sub_services'), true) ?: [];
        $req->merge([
            'sub_services' => $sub_services
        ]);

        $req->validate([
            'name' => ['required', 'string', 'min:5', 'max:250', 'unique:services,name'],
            'service_type' => ['required', 'integer', 'min:1', 'max:2'],
            'local_name' => ['required', 'string', 'min:5', 'max:250', 'unique:services,local_name'],
            'description' => ['required', 'string', 'min:5', 'unique:services,description'],
            'local_description' => ['required', 'string', 'min:5', 'unique:services,local_description'],
            'sub_services' => ['required', 'array'],
            'sub_services.*.description' => ['string', 'min:5'],
            'sub_services.*.local_description' => ['string', 'min:5'],
            'sub_services.*.price' => ['numeric'],
            'sub_services.*.is_active' => ['boolean'],
            'images' => ['required', 'array'],
            'images.*' => ['file', 'mimes:png,jpeg,jpg', 'max:1024'],
            'instruction' => ['nullable', 'string'],

        ]);

        $service = new Service;
        $service->name = $req->input('name');
        $service->service_type = $req->input('service_type');
        $service->local_name = $req->input('local_name');
        $service->description = $req->input('description');
        $service->local_description = $req->input('local_description');
        $service->instruction = htmlentities($req->input('instruction'), ENT_QUOTES, 'UTF-8') ?? null;

        $service->save();

        if (!empty($req->sub_services)) {
            foreach ($req->sub_services as $subService) {
                $subService['service_id'] = $service->id;
                SubService::create([
                    'service_id' => $subService['service_id'],
                    'description' => $subService['description'],
                    'local_description' => $subService['local_description'],
                    'price' => $subService['price'],
                    'is_active' => $subService['is_active'],
                ]);
            }
        }

        if ($req->hasFile('images')) {
            foreach ($req->file('images') as $image) {
                $imagePath = $image->store('service', 'public');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return $this->res_success('Store success');
    }
    public function updateMain(Request $req, $id)
    {
        $req->merge(['id' => $id]);

        $req->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:services,id'],
            'service_type' => ['required', 'integer', 'min:1', 'max:2'],
            'name' => ['required', 'string', 'min:5', 'max:250', "unique:services,name,{$id},id"],
            'local_name' => ['required', 'string', 'min:5', 'max:250', "unique:services,local_name,{$id},id"],
            'description' => ['required', 'string', 'min:5', 'max:65530'],
            'local_description' => ['required', 'string', 'min:5', 'max:65530'],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'mimes:png,jpeg,jpg', 'max:1024'],
            'instruction' => ['nullable', 'string'],

        ]);

        $service = Service::findOrFail($id);

        // $instruction = null;
        // if ($req->filled('instruction')) {
        //     $instruction = ;
        // }
        $service->update([
            'name' => $req->input('name'),
            'local_name' => $req->input('local_name'),
            'description' => $req->input('description'),
            'local_description' => $req->input('local_description'),
            'service_type' => $req->input('service_type'),
            'instruction' => htmlentities($req->input('instruction'), ENT_QUOTES, 'UTF-8'),
        ]);

        try {
            if ($req->has('images')) {
                $oldImages = ServiceImage::where('service_id', $id)->get();
                if ($oldImages->isNotEmpty()) {
                    foreach ($oldImages as $img) {
                        if (Storage::disk('public')->exists($img->image_path)) {
                            Storage::disk('public')->delete($img->image_path);
                            $img->delete();
                        }
                    }
                }
                foreach ($req->file('images') as $image) {
                    $imagePath = $image->store('service', 'public');
                    Log::info($imagePath);
                    ServiceImage::create([
                        'service_id' => $service->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image update failed'], 500);
        }
        return $this->res_success('Update success', $service->instruction);
    }

    public function updateSub(Request $req, $id)
    {
        $sub_services = json_decode($req->input('sub_services'), true) ?: [];
        $req->merge([
            'id' => $id,
            'sub_services' => $sub_services
        ]);

        $req->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:services,id'],
            'sub_services' => ['required', 'array', 'min:1'],
            'sub_services.*.id' => ['nullable', 'integer', 'exists:sub_services,id'],
            'sub_services.*.description' => ['required', 'string', 'min:5'],
            'sub_services.*.local_description' => ['required', 'string', 'min:5'],
            'sub_services.*.price' => ['required', 'numeric', 'min:0'],
            'sub_services.*.is_active' => ['required', 'boolean'],
        ]);

        $service_id = $req->input('id');
        foreach ($sub_services as $serviceData) {
            if (!empty($serviceData['id']) && is_numeric($serviceData['id']) && SubService::where('id', $serviceData['id'])->exists() && !($serviceData['isNew'] ?? false)) {
                Log::info('update');
                $sub = SubService::find($serviceData['id']);
                $sub->update([
                    'description' => $serviceData['description'],
                    'local_description' => $serviceData['local_description'],
                    'price' => $serviceData['price'],
                    'is_active' => $serviceData['is_active'],
                ]);
            } else {
                Log::info('Creating new sub-service:', ['service_id' => $service_id, 'data' => $serviceData]);
                try {
                    $created = SubService::create([
                        'service_id' => $service_id,
                        'description' => $serviceData['description'],
                        'local_description' => $serviceData['local_description'],
                        'price' => $serviceData['price'],
                        'is_active' => $serviceData['is_active'],
                    ]);
                    Log::info('Sub-service created:', ['id' => $created->id]);
                } catch (\Exception $e) {
                    Log::error('Failed to create sub-service:', ['error' => $e->getMessage(), 'data' => $serviceData]);
                    return $this->res_success('Failed to create sub-service: ' . $e->getMessage());
                }
            }
        }

        return $this->res_success('update successful');
    }
    public function destroy(Request $req, $id)
    {
        $req->merge(['id' => $id]);
        $req->validate(['id' => ['required', 'integer', 'min:1', 'exists:services,id']]);

        $images = ServiceImage::where('service_id', $req->id)->get();

        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        Service::where('id', $id)->delete();

        return $this->res_success('Delete successful', $images);
    }
}
