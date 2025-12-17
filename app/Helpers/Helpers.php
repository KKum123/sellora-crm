<?php

namespace App\Helpers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Log;
use Image;
use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function getAccessToken($serviceAccountFilePath)
    {
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];

        // Create the credentials object
        $credentials = new ServiceAccountCredentials($scopes, $serviceAccountFilePath);
        $token = $credentials->fetchAuthToken();

        // Fetch the access token
        return $token['access_token'];
    }

    public static function imageResize($image, $width = null, $height = null, $dir)
    {
        // Check if the image is not null and is a valid file
        if ($image && $image->isValid()) {
            $i = rand(100, 999); // Generate a unique image name
            $imageName = $i . time() . "-" . uniqid() . "." . 'png';

            // Create directory if it doesn't exist
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }

            // Upload the image using storeAs method
            $imagePath = $image->storeAs($dir, $imageName, 'public');
           
            // Resize the uploaded image if both width and height are provided
           
                // Get the full path of the uploaded image
                $fullImagePath = storage_path('app/public/' . $imagePath);

                // Check if the image file exists and is readable
                if (is_readable($fullImagePath)) {
                    
                    $image = Image::make($fullImagePath);

                    // Resize only if width and height are provided
                    if ($width && $height) {
                        $image->resize($width, $height);
                    }
                
                    // Save the image (resized or original)
                    $image->save();
                } else {
                    // Log or handle the error if the image file is not readable
                    // For example, Log::error("Image file not found or not readable: $fullImagePath");
                }
            

            return 'storage/'.$imagePath; // Return the stored image path
        } else {
            // Log or handle the error if the image is null or not valid
            // For example, Log::error("Invalid or no image file provided.");
            return null;
        }
    }

    public static function imageResizeBase64($base64String, $width = null, $height = null, $dir)
    {
        // Check if the provided string is a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            // Get the image type (e.g., 'png', 'jpeg', 'gif')
            $imageType = strtolower($type[1]);

            // Generate a unique image name
            $imageName = uniqid() . time() . '.' . $imageType;

            // Create directory if it doesn't exist
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }

            // Decode the base64-encoded image data
            $decodedData = base64_decode(substr($base64String, strpos($base64String, ',') + 1));

            // Resize the image if both width and height are provided
            if ($width && $height) {
                // Create an Intervention Image instance
                $image = Image::make($decodedData);

                // Resize the image
                $image->resize($width, $height);

                // Save the resized image
                $image->save(storage_path("app/public/{$dir}/{$imageName}"));
            } else {
                // Save the original image if no width and height are provided
                Storage::disk('public')->put("{$dir}/{$imageName}", $decodedData);
            }

            return 'storage' . $dir . '/' . $imageName;
        }

        return 'Invalid base64 image string.';
    }
    public static function percentage($mrp_price, $discounted_price)
    {
        return bcdiv((($mrp_price - $discounted_price) / $mrp_price) * 100, 1);
    }
    public static function uploadFile($dir, $file)
    {
        // Generate a unique file name
        $fileName = date('Y-m-d') . "-" . rand(100, 999) . time() . "-" . uniqid() . "." . $file->getClientOriginalExtension();
        
        // Check if the directory exists, create it if not
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }

        // Store the file in the specified directory
        $filePath = $file->storeAs($dir, $fileName, 'public');

        // Get the full path of the uploaded file
        $fullFilePath = storage_path('app/public/' . $filePath);

        try {
            // Check if the file is readable
            if (is_readable($fullFilePath)) {
                // Optionally log or process the file here
            } else {
                // Handle the case where the file is not readable
                Log::error('File not readable: ' . $fullFilePath);
                // return false; // Optionally return false or handle the error in your own way
            }
        } catch (\Exception $e) {
            // Handle any exceptions during file processing
            Log::error('Error processing file: ' . $e->getMessage());
            // return false;
        }

        // Return the relative URL to the uploaded file
        return 'storage/' . $filePath;
    }
    public static function statusColor($peram=null){
        $data = '<span class="orangestatus">Pending</span>';
        
        if($peram=='Pitch In Progress'){
            $data = '<span class="bluestatus">Pitch In Progress</span>';
        }
        if($peram=='Not Reachable'){
            $data = '<span class="yellowstatus">Not Reachable</span>';
        }
        if($peram=='Completed'){
            $data = '<span class="greenstatus">Completed</span>';
        }
        if($peram=='Cancelled'){
            $data = '<span class="darkredstatus">Cancelled</span>';
        }
        if($peram=='Not Interested'){
            $data = '<span class="redstatus">Not Interested</span>';
        }
        if($peram=='In Progress'){
            $data = '<span class="bluestatus">In Progress</span>';
        }
        if($peram=='Not Started'){
            $data = '<span class="orangestatus">Not Started</span>';
        }
        

        return $data;
    }
    public static function countryOrCode(){
        $list = file_get_contents(public_path('countryPhoneCodes.json'));
        return json_decode($list, true); 
    }
}
