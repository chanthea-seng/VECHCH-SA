<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function res_success($msg = '', $data = null)
    {
        return response()->json([
            'result' => true,
            'message' => $msg,
            'data' => $data,
        ]);
    }
    public function res_paginate($msg = '', $data = null, $page)
    {
        return response()->json([
            'result' => true,
            'message' => $msg,
            'data' => $data,
            'paginate' => [
                'total' => $page->total(),
                'total_page' => $page->lastPage(),
                'current_page' => $page->currentPage(),
                'has_more_pages' => $page->hasMorePages(),
                'has_page' => $page->hasPages()
            ],
        ]);
    }
}
