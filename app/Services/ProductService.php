<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    private const FILE_PATH = 'products';

    public function categoryProducts(Category $category, $size, $orderBy, $sort, $min, $max): array
    {
        $query = $category->products()->active();
        $minimal = $query->min('price');
        $maximal = $query->max('price');
        $query->when($min, function ($query) use ($min) {
                return $query->where('price', '>=', $min);
            })->when($max, function ($query, $max) {
            return $query->where('price', '<=', $max);
        })
            ->orderBy($orderBy, $sort);
        $data['products'] = $query->paginate($size);
        $data['append'] = [
            'min_price' => $minimal,
            'max_price' => $maximal
        ];

        return $data;
    }

    public function myProducts($size, $orderBy, $sort, $min, $max): array
    {
        $query = Auth::user()->products()
            ->when($min, function ($query) use ($min) {
                return $query->where('price', '>=', $min);
            });
        $minimal = $query->min('price');
        $maximal = $query->max('price');
        $query->when($max, function ($query, $max) {
            return $query->where('price', '<=', $max);
        })
            ->orderBy($orderBy, $sort);

        $min = $query->min('price');
        $max = $query->max('price');

        $data['products'] = $query->paginate($size);
        $data['append'] = [
            'min_price' => $minimal,
            'max_price' => $maximal
        ];

        return $data;
    }

    public static function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $product = Product::create($data);
        if (array_key_exists('main_image', $data)) {
            self::saveResource($data['main_image'], $product->mainImage(), Product::PRODUCT_MAIN_IMAGE_RESOURCES, self::FILE_PATH);
            $product->load('mainImage');
        }
        if (array_key_exists('images', $data)) {
            foreach ($data['images'] as $image)
                self::saveResource($image, $product->images(), Product::PRODUCT_IMAGES_RESOURCES, self::FILE_PATH);
            $product->load('images');
        }
        if (array_key_exists('video', $data)) {
            self::saveResource($data['video'], $product->video(), Product::PRODUCT_VIDEO_RESOURCES, self::FILE_PATH . "/videos");
            $product->load('video');
        }
        return $product;
    }

    public static function update(array $data)
    {
        $product = Product::query()->find($data['id']);
        $product->update($data);
        if (array_key_exists('main_image', $data)) {
            if ($product->mainImage()->exists()) {
                $product->mainImage->removeFile();
                $product->mainImage()->delete();
            }
            self::saveResource($data['main_image'], $product->mainImage(), Product::PRODUCT_MAIN_IMAGE_RESOURCES, self::FILE_PATH);
            $product->load('mainImage');
        }
        if (array_key_exists('images', $data)) {
            foreach ($data['images'] as $image)
                self::saveResource($image, $product->images(), Product::PRODUCT_IMAGES_RESOURCES, self::FILE_PATH);
            $product->load('images');
        }
        if (array_key_exists('video', $data)) {
            if ($product->video()->exists()) {
                $product->video->removeFile();
                $product->video()->delete();
            }
            self::saveResource($data['video'], $product->video(), Product::PRODUCT_VIDEO_RESOURCES, self::FILE_PATH . "/videos");
            $product->load('video');
        }
        return $product;
    }

    /**
     * @param UploadedFile $file
     * @param $product
     * @param string $identifier
     * @param string $path
     */
    private static function saveResource(UploadedFile $file, $product, string $identifier, string $path)
    {
        $fileName = md5(time() . $file->getFilename()) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $fileName);

        $product->create([
            'name' => $fileName,
            'type' => $file->Extension(),
            'full_url' => "uploads/$path/$fileName",
            'additional_identifier' => $identifier
        ]);
    }

    public function similar(Product $id, $size): LengthAwarePaginator
    {
        $tags = explode(',', $id->tag);

        return Product::query()
            ->where('id', '!=', $id->id)
            ->where(function ($query) use ($tags) {
                foreach ($tags as $tag)
                    $query->orWhere('tag', 'LIKE', "%$tag%");
            })
            ->orderBy('position', 'DESC')
            ->orderBy("name", 'ASC')
            ->paginate($size);
    }

    public function delete(Product $id): ?bool
    {
        if ($id->user_id !== Auth::id()) {
            throw new \Exception(__('messages.not_your_product'), 403);
        }
        return $id->delete();
    }

    public function search(string $search, $size, $orderBy, $sort, $min, $max): array
    {
        $query = Product::query()->active()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('tag', 'like', "%$search%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        $minimal = $query->min('price');
        $maximal = $query->max('price');

        $query->when($min, function ($query) use ($min) {
            return $query->where('price', '>=', $min);
        })
            ->when($max, function ($query, $max) {
                return $query->where('price', '<=', $max);
            })
            ->orderBy($orderBy, $sort);
        $data['products'] = $query->paginate($size);
        $data['append'] = [
            'min_price' => $minimal,
            'max_price' => $maximal
        ];
        return $data;
    }
}
