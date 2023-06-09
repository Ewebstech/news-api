<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class ImageUploader
{
    //upload images function
    public static function img_upload(Request $request, string $model_name, $model, string $stmt)
    {
        if ($model_name === 'feed') {
            $feed = $model;
            if ($request->file('feed_logo')) {

                switch ($stmt) {
                    //insert
                    case 'insert':
                        try {
                            $feed_logo_url = $request->file('feed_logo');
                            $feed_logo_name = 'feed_' . rand() . '.' . $feed_logo_url->getClientOriginalExtension();

                            $feed_logo_url->move(storage_path('app/public/uploads/images/feeds/'), $feed_logo_name);
                            return $feed_logo_name;


                        } catch (ValidationException $e) {
                            $e->getMessage();
                        }
                        break;

                    // update
                    case 'update':

                        try {
                            $feed_logo_url = $request->file('feed_logo');
                            $feed_logo_name = 'feed_' . rand() . '.' . $feed_logo_url->getClientOriginalExtension();

                            $old_feed_logo = storage_path('app/public/uploads/images/feeds/') . $feed->logo; // get previous logo from folder

                            if (File::exists($old_feed_logo)) { // unlink or remove previous logo from folder
                                unlink($old_feed_logo);
                            }

                            $feed_logo_url->move(storage_path('app/public/uploads/images/feeds/'), $feed_logo_name);
                            return $feed_logo_name;


                        } catch (ValidationException $e) {
                            $e->getMessage();
                        }
                        break;
                }
            }

        } elseif ($model_name === 'cat') {

            $cat = $model;

            if ($request->file('cat_logo')) {
                switch ($stmt) {
                    //insert
                    case 'insert':
                        try {
                            $cat_logo_url = $request->file('cat_logo');
                            $cat_logo_name = 'cat_' . rand() . '.' . $cat_logo_url->getClientOriginalExtension();

                            $cat_logo_url->move(storage_path('app/public/uploads/images/cats/'), $cat_logo_name);
                            return $cat_logo_name;


                        } catch (ValidationException $e) {
                            $e->getMessage();
                        }
                        break;

                    // update
                    case 'update':

                        try {
                            $cat_logo_url = $request->file('cat_logo');
                            $feed_logo_name = 'cat_' . rand() . '.' . $cat_logo_url->getClientOriginalExtension();

                            $old_cat_logo = storage_path('app/public/uploads/images/cats/') . $cat->logo; // get previous logo from folder

                            if (File::exists($old_cat_logo)) { // unlink or remove previous logo from folder
                                unlink($old_cat_logo);
                            }

                            $cat_logo_url->move(storage_path('app/public/uploads/images/cats/'), $feed_logo_name);
                            return $feed_logo_name;


                        } catch (ValidationException $e) {
                            $e->getMessage();
                        }
                        break;
                }
            }
        } else {
            if ($model_name === 'item') {
                $item = $model;
                if ($request->file('item_thumbnail')) {

                    switch ($stmt) {
                        //insert
                        case 'insert':
                            try {
                                $item_logo_url = $request->file('item_thumbnail');
                                $item_logo_name = 'item_' . rand() . '.' . $item_logo_url->getClientOriginalExtension();

                                $item_logo_url->move(storage_path('app/public/uploads/images/items/'), $item_logo_name);

                                return $item_logo_name;


                            } catch (ValidationException $e) {
                                $e->getMessage();
                            }
                            break;

                        // update
                        case 'update':

                            try {
                                $item_logo_url = $request->file('item_thumbnail');
                                $item_logo_name = 'item_' . rand() . '.' . $item_logo_url->getClientOriginalExtension();

                                if ($item->thumbnail != '') {
                                    $old_item_logo = storage_path('app/public/uploads/images/items/') . $item->thumbnail; // get previous logo from folder
                                    unlink($old_item_logo);// remove previous logo from folder

                                }

                                $item_logo_url->move(storage_path('app/public/uploads/images/items/'), $item_logo_name);

                                return $item_logo_name;


                            } catch (ValidationException $e) {
                                $e->getMessage();
                            }
                            break;
                    }
                }

            }
        }

    }
}

