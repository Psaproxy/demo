<?php

namespace App\Http\Controllers;

use Core\Counter\Actions\GetStat;
use Core\Counter\Actions\IncValueOffset;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use function resource_path;
use function response;

class BannerController extends Controller
{
    private IncValueOffset $incValue;
    private GetStat $getStat;

    public function __construct(IncValueOffset $incValue, GetStat $getStat)
    {
        $this->incValue = $incValue;
        $this->getStat = $getStat;
    }

    /**
     * @throws \Throwable
     */
    public function get(): BinaryFileResponse
    {
        $this->incValue->execute('banner');

        return response()->file(resource_path('images/banner.png'));
    }

    /**
     * @throws \Throwable
     */
    public function getStat(): JsonResponse
    {
        $stat = $this->getStat->execute('banner');

        if (0 === $stat->value) {
            $updateAt = '';
        } else {
            $updateAt = $stat->updateAt->format('H:i:s d.m.Y');
        }

        return response()->json([
            'value' => $stat->value,
            'update_at' => $updateAt,
        ]);
    }
}
