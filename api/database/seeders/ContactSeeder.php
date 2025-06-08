<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataContacts = [
            ['user_id' => 6, 'fname' => 'សុភា', 'lname' => 'លី', 'email' => 'sophea.li@example.com', 'phone' => '012345678', 'message' => 'ខ្ញុំចង់សួរអំពីការពិនិត្យសុខភាព', 'status' => 'qa'],
            ['user_id' => 7, 'fname' => 'វិចិត្រ', 'lname' => 'សេង', 'email' => 'vicheat.seng@example.com', 'phone' => '098765432', 'message' => 'សូមអរគុណចំពោះសេវាកម្មល្អ', 'status' => 'feedback'],
            ['user_id' => 8, 'fname' => 'ពៅ', 'lname' => 'មុនី', 'email' => 'pov.mony@example.com', 'phone' => '011223344', 'message' => 'តើខ្ញុំអាចកក់ពេទ្យបែបណា?', 'status' => 'qa'],
            ['user_id' => 9, 'fname' => 'ស្រីល័ក្ខ', 'lname' => 'ឈុន', 'email' => 'sreylak.chhun@example.com', 'phone' => '015667788', 'message' => 'ពេទ្យនៅទីនេះពិតជាល្អ', 'status' => 'feedback'],
            ['user_id' => 10, 'fname' => 'វិសាល', 'lname' => 'ម៉េង', 'email' => 'visal.meng@example.com', 'phone' => '099112233', 'message' => 'ខ្ញុំមានបញ្ហាសុខភាព តើគួរចាប់ផ្តើមពីណា?', 'status' => 'qa'],
            ['user_id' => 11, 'fname' => 'សុវណ្ណ', 'lname' => 'ឃាង', 'email' => 'sovann.kheng@example.com', 'phone' => '088445566', 'message' => 'សេវាកម្មស្អាត និងរហ័ស', 'status' => 'feedback'],
            ['user_id' => 12, 'fname' => 'អ៊ុំ', 'lname' => 'ផាន', 'email' => 'oum.phan@example.com', 'phone' => '066778899', 'message' => 'តើមានសេវាកម្មពិនិត្យជំងឺអ្វីខ្លះ?', 'status' => 'qa'],
            ['user_id' => 13, 'fname' => 'ជា', 'lname' => 'នី', 'email' => 'chea.ni@example.com', 'phone' => '077889900', 'message' => 'ខ្ញុំចង់បំពេញទិន្នន័យបន្ថែម', 'status' => 'feedback'],
            ['user_id' => 14, 'fname' => 'ព្រំ', 'lname' => 'សុខ', 'email' => 'prom.sok@example.com', 'phone' => '011445566', 'message' => 'តើខ្ញុំអាចជ្រើសពេទ្យផ្ទាល់ខ្លួនបានទេ?', 'status' => 'qa'],
            ['user_id' => 15, 'fname' => 'វីរៈ', 'lname' => 'លឹម', 'email' => 'veara.lim@example.com', 'phone' => '092334455', 'message' => 'ការបំផុសព័ត៌មានគឺល្អ', 'status' => 'feedback'],
            ['user_id' => 16, 'fname' => 'នីត', 'lname' => 'ឡុង', 'email' => 'nith.long@example.com', 'phone' => '067778899', 'message' => 'តើខ្ញុំអាចជ្រើសពេទ្យអន្តរជាតិនៅទីនេះបានទេ?', 'status' => 'qa'],
        ];

        foreach ($dataContacts as $data) {
            $contact = new Contact();
            $contact->user_id = $data['user_id'];
            $contact->fname = $data['fname'];
            $contact->lname = $data['lname'];
            $contact->email = $data['email'];
            $contact->phone = $data['phone'];
            $contact->message = $data['message'];
            $contact->status = $data['status'];
            $contact->save();
        }
    }
}
