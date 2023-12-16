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
     * Build Filter and query article function
     *
     * @param array $filter
     * @param array $paginate
     * @return array
     */
    public function getHouseArticles(array $filter, array $paginate)
    {
        $query = HouseArticle::query();
        // TODO:
        // $query = $query->where('type', $filter['type'])->where('status', HouseArticle::STATUS_ACCEPTED);
        $query = $query->where('type', $filter['type']);

        if ($filter['sort_fields']) {
            $query = $query->orderBy($filter['sort_fields'], $filter['sort_order']);
        }

        $data = $query->paginate($paginate['per_page'], ['*'] , 'page', $paginate['page']);

        return [Response::HTTP_OK, $data->toArray()];
    }

    /**
     * Build Filter and query article function
     *
     * @param array $filter
     * @param array $paginate
     * @return array
     */
    public function getServiceArticles(array $filter, array $paginate)
    {
        $query = ServiceArticle::query();

        $data = $query->paginate($paginate['per_page'], ['*'] , 'page', $paginate['page']);

        return [Response::HTTP_OK, $data->toArray()];
    }

    /**
     * storeHouseArticle function
     *
     * @param array $data
     * @return array
     */
    public function storeHouseArticle(array $data)
    {
        $user = request()->user();

        $nextAutoIncrement = HouseArticle::next();
        $slug = \Str::slug($data['title']) . '-' . $nextAutoIncrement;
        $haData = HouseArticle::where('slug', $slug)->withTrashed()->exists();

        if ($haData) {
            return [Response::HTTP_BAD_REQUEST, ['message' => 'This title exists.']];
        }

        $dataSave = [
            'user_id' => $user->id,
            'title' => $data['title'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'slug' => $slug,
            'images' => [],
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

        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                // Lưu ảnh
                $filename = Str::uuid(time()) . '-' . trim($image->getClientOriginalName(), ' ');
                $path = '/img/house_articles';
                $uploadPath = public_path($path);

                // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                if (move_uploaded_file($image, $uploadPath . '/' . $filename)) {
                    $dataSave['images'][] = $path . '/' . $filename;
                } else {
                    return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
                }
            }
        }

        try {
            $houseArticle = HouseArticle::create($dataSave);
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * storeServiceArticle function
     *
     * @param array $data
     * @return void
     */
    public function storeServiceArticle(array $data)
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
            'images' => [],
            'price' => $data['price'],
            'status' => ServiceArticle::STATUS_WAITING_ACCEPT,
        ];

        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                // Lưu ảnh
                $filename = Str::uuid(time()) . '-' . trim($image->getClientOriginalName(), ' ');
                $path = '/img/service_articles';
                $uploadPath = public_path($path);

                // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                if (move_uploaded_file($image, $uploadPath . '/' . $filename)) {
                    $dataSave['images'][] = $path . '/' . $filename;
                } else {
                    return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
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

    public function softDeleteHA($params)
    {
        try {
            $houseArticle = HouseArticle::withTrashed()->find($params['id']);

            if ($houseArticle) {
                if (!empty($params['hard_delete']) && $params['hard_delete']) {
                    $houseArticle->forceDelete();
                } else {
                    $houseArticle->delete();
                }
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
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

    public function softDeleteSA($params)
    {
        try {
            $serviceArticle = ServiceArticle::withTrashed()->find($params['id']);

            if ($serviceArticle) {
                if (!empty($params['hard_delete']) && $params['hard_delete']) {
                    $serviceArticle->forceDelete();
                } else {
                    $serviceArticle->delete();
                }
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
