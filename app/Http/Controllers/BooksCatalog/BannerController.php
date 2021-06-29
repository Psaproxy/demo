<?php

namespace App\Http\Controllers\BooksCatalog;

use App\Http\Controllers\Controller;
use Core\Counter\Actions\GetUpdatedAt;
use Core\Counter\Actions\GetValue;
use Core\Counter\Actions\IncValue;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class BannerController extends Controller
{
    private IncValue $incValue;
    private GetValue $getValue;
    private GetUpdatedAt $getUpdatedAt;

    public function __construct(IncValue $incValue, GetValue $getValue, GetUpdatedAt $getUpdatedAt)
    {
        $this->incValue = $incValue;
        $this->getValue = $getValue;
        $this->getUpdatedAt = $getUpdatedAt;
    }

    /**
     * @throws \Throwable
     */
    public function get(): BinaryFileResponse
    {
        $id = 'banner';

        $this->incValue->execute($id);

        return response()->file(resource_path('images/banner.png'));
    }

    /**
     * @throws \Throwable
     */
    public function getStat(): JsonResponse
    {
        $id = 'banner';

        return response()->json([
            'value' => $this->getValue->execute($id),
            'update_at' => $this->getUpdatedAt->execute($id)->format('H:i:s d.m.Y'),
        ]);
    }
}
