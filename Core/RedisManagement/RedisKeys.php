<?php

namespace Core\RedisManagement;

class RedisKeys
{
    public static function pornstarThumbnailKey($id)
    {
        return "pornstar:{$id}:thumbnail";
    }

    public static function pornstarDataKey($id)
    {
        return "pornstar:{$id}:data";
    }

    public static function pornstarIdKey($id)
    {
        return "pornstar:{$id}:id";
    }
}
