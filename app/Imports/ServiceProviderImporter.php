<?php

namespace App\Imports;

use App\Http\Controllers\Admins\ServiceProvidersController;
use App\Models\Category;
use App\Models\ServiceProviderProfile;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServiceProviderImporter implements ToCollection,WithHeadingRow,SkipsEmptyRows
{

    public function collection(Collection $rows)
    {
        foreach ($rows->toArray() as $row) {
            //Check if User Exists
            $user = User::where('email',trim($row['email']))->first();

            //Create User with Role Service Provider
            if(!$user){
                $user = new User();
                $user->name = array_key_exists('name', $row) ? ucwords(trim($row['name'])) : null;
                $user->primary_mobile_number = array_key_exists('contact_number', $row) ? strtolower(trim($row['contact_number'])) : null;
                $user->email = array_key_exists('email', $row) ? strtolower(trim($row['email'])) : null;
                if(array_key_exists('email',$row) && $row['email'] !== null) {
                    if(!isset($user->email)){
                        $user->email = strtolower(trim($row['email']));
                    }
                }
                if((array_key_exists('email',$row) && $row['email'] !== null) && (array_key_exists('password',$row) && $row['password'] !== null)) {
                    $user->password = bcrypt(trim($row['password']));
                }
                $user->offline_verification = array_key_exists('offline_verification', $row) ? strtolower(trim($row['offline_verification'])) : 'pending';
                $user->status = array_key_exists('status', $row) ? strtolower(trim($row['status'])) : 'pending';
                $user->role = 'service-provider';
                $user->save();
                $user->refresh();

                //Create User Profile
                $categoryId = Category::where('name','LIKE','%'.trim($row['category']).'%')->first();
                $categories = $categoryId ? json_encode([$categoryId->id]) : json_encode([]);

                $user->serviceproviderprofile()->create([
                    'first_name'=>array_key_exists('first_name', $row) ? ucwords(trim($row['first_name'])) : null,
                    'last_name'=>array_key_exists('last_name', $row) ? ucwords(trim($row['last_name'])) : null,
                    'company_name'=>array_key_exists('company_name', $row) ? ucwords(trim($row['company_name'])) : null,
                    'company_designation'=>array_key_exists('designation', $row) ? ucwords(trim($row['designation'])) : null,
                    'company_gst_no'=>array_key_exists('gst_number', $row) ? ucwords(trim($row['gst_number'])) : null,
                    'categories'=>$categories,
                    'company_email'=>array_key_exists('company_email', $row) ? strtolower(trim($row['company_email'])) : null,
                    'contact_number'=>array_key_exists('contact_number', $row) ? strtolower(trim($row['contact_number'])) : null,
                    'alternate_contact_number'=>array_key_exists('whatsapp_number', $row) ? strtolower(trim($row['whatsapp_number'])) : null,
                    'website'=>array_key_exists('website', $row) ? strtolower(trim($row['website'])) : null,
                    'address'=>array_key_exists('address', $row) ? ucwords(trim($row['address'])) : null,
                    'pin_code'=>array_key_exists('pincode', $row) ? strtolower(trim($row['pincode'])) : null,
                    'city'=>array_key_exists('city', $row) ? ucwords(trim($row['city'])) : null,
                    'region'=>array_key_exists('region', $row) ? ucwords(trim($row['region'])) : null,
                    'state'=>array_key_exists('state', $row) ? ucwords(trim($row['state'])) : null,
                    'company_description'=>array_key_exists('description', $row) ? trim($row['description']) : null,
                ]);

            }

        }
    }
}
