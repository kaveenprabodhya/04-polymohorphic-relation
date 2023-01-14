<?php

namespace App\Services;

// use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Cache\Factory as Cache;

class Counter
{

    private $timeout;
    private $cache;
    private $session;

    public function __construct(Cache $cache, Session $session, int $timeout = 1)
    {
        $this->cache = $cache;
        $this->timeout = $timeout;
        $this->session = $session;
    }

    public function increment(string $key): int
    {
        $sessionId = $this->session->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        $cache = $this->cache;

        $users = $cache->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;

        foreach ($users as $session => $lastVisit) {
            if (now()->diffInMinutes($lastVisit) >= $this->timeout) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || now()->diffInMinutes($users[$sessionId]) >= $this->timeout) {
            $difference++;
        }

        $usersUpdate[$sessionId] = now();
        $cache->forever($usersKey, $usersUpdate);

        if (!$cache->has($counterKey)) {
            $cache->forever($counterKey, 1);
        } else {
            $cache->increment($counterKey, $difference);
        }

        $counter = $cache->get($counterKey);
        return $counter;
    }
}