<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\HouseArticle;
use Illuminate\Http\Response;
use App\Models\ServiceArticle;
use Illuminate\Support\Facades\File;

class ArticleService implements ArticleServiceInterface
{
    /**
     * storeHouseArticale function
     *
     * @param array $data
     * @return array
     */
    public function storeHouseArticale(array $data)
    {
        $user = request()->user();
        $nextAutoIncrement = HouseArticle::next();
        $slug = \Str::slug($data['title']) . '-' . $nextAutoIncrement;
        $haData = HouseArticle::where('slug', $slug)->withTrashed()->exists();

        $dataSave = [
            'user_id' => $user->id,
            'title' => $data['title'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'slug' => $slug,
            'images' => !empty($data['images']) ? $data['images'] : [],
            'type' => $data['type'],
            'price' => $data['price'],
            'status' => HouseArticle::STATUS_WAITING_ACCEPT,
            'area' => empty($data['area']) ? 0 : $data['area'],
            'bedrooms' => empty($data['bedrooms']) ? 0 : $data['bedrooms'],
            'wcs' => empty($data['wcs']) ? 0 : $data['wcs'],
            'livingrooms' => null,
            'address' => null,
            'direction_house' => empty($data['direction_house']) ? '' : $data['direction_house'],
            'house_number' => empty($data['house_number']) ? 0 : $data['house_number'],
            'kind' => HouseArticle::NEWS_NORMAL
        ];

        if (!empty($dataSave['images'])) {
            foreach ($dataSave['images'] as $dataImage) {
                // Lưu ảnh
                if (!empty($dataImage)) {
                    $profile = $dataImage;
                    $filename = Str::uuid(time()) . '_' . $profile->getClientOriginalName();
                    $path = '/img/house_articles';
                    $uploadPath = public_path($path);

                    // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    if (move_uploaded_file($profile, $uploadPath . '/' . $filename)) {
                        $dataSave['images'][] = $path . '/' . $filename;
                    } else {
                        return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
                    }
                }
            }
        }

        try {
            if (!$haData) {
                $houseArticle = HouseArticle::create($dataSave);
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This title exists.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * storeServiceArticale function
     *
     * @param array $data
     * @return void
     */
    public function storeServiceArticale(array $data)
    {
        $user = request()->user();
        $nextAutoIncrement = HouseArticle::next();
        $slug = \Str::slug($data['title']) . '-' . $nextAutoIncrement;
        $saData = ServiceArticle::where('slug', $slug)->withTrashed()->exists();

        $dataSave = [
            'user_id' => $user->id,
            'title' => $data['title'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'slug' => $slug,
            'images' => !empty($data['images']) ? [$data['images']] : [],
            'price' => $data['price'],
            'status' => ServiceArticle::STATUS_WAITING_ACCEPT,
        ];

        if (!empty($dataSave['images'])) {
            foreach ($dataSave['images'] as $dataImage) {
                // Lưu ảnh
                if (!empty($dataImage)) {
                    $profile = $dataImage;
                    $filename = Str::uuid(time()) . '_' . $profile->getClientOriginalName();
                    $path = '/img/service_articles';
                    $uploadPath = public_path($path);

                    // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    if (move_uploaded_file($profile, $uploadPath . '/' . $filename)) {
                        $dataSave['images'][] = $path . '/' . $filename;
                    } else {
                        return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
                    }
                }
            }
        }

        try {
            if (!$saData) {
                ServiceArticle::create($dataSave);
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This title exists.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    public function hardDeleteHA(int $id)
    {
        try {
            $houseArticle = HouseArticle::withTrashed()->find($id);

            if ($houseArticle) {
                $houseArticle->forceDelete();
                return [Response::HTTP_OK, ['message' => 'This record has force deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }

    public function softDeleteHA(int $id)
    {
        try {
            $houseArticle = HouseArticle::find($id);

            if ($houseArticle) {
                $houseArticle->delete();
                return [Response::HTTP_OK, ['message' => 'This record has soft deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }

    public function hardDeleteSA(int $id)
    {
        try {
            $serviceArticle = ServiceArticle::withTrashed()->find($id);

            if ($serviceArticle) {
                $serviceArticle->forceDelete();
                return [Response::HTTP_OK, ['message' => 'This record has force deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }

    public function softDeleteSA(int $id)
    {
        try {
            $serviceArticle = ServiceArticle::find($id);

            if ($serviceArticle) {
                $serviceArticle->delete();
                return [Response::HTTP_OK, ['message' => 'This record has soft deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
