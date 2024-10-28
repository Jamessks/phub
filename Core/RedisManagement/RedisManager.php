<?php

namespace Core\RedisManagement;

use Redis;

class RedisManager
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->connect();
    }

    private function connect(): void
    {
        $this->redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
    }

    public function get(string $key)
    {
        return $this->redis->get($key);
    }

    public function set(string $key, $value, int $expiration = 0): bool
    {
        if ($expiration > 0) {
            return $this->redis->setex($key, $expiration, $value);
        }
        return $this->redis->set($key, $value);
    }

    public function delete(string $key): bool
    {
        return $this->redis->del($key) > 0;
    }

    public function exists(string $key): bool
    {
        return $this->redis->exists($key) > 0;
    }

    public function flushAll(): bool
    {
        return $this->redis->flushAll();
    }

    public function close(): void
    {
        $this->redis->close();
    }

    public function keys(string $pattern): array
    {
        return $this->redis->keys($pattern);
    }

    public function deleteAllByPattern(string $pattern): int
    {
        $keys = $this->keys($pattern);
        $deletedCount = 0;

        foreach ($keys as $key) {
            $deletedCount += $this->delete($key);
        }

        return $deletedCount;
    }
}
