<?php

namespace Http\models;

class Stats
{
    private ?int $subscriptions;
    private ?int $monthlySearches;
    private ?int $views;
    private ?int $videosCount;
    private ?int $premiumVideosCount;
    private ?int $whiteLabelVideoCount;
    private ?int $rankValue;
    private ?int $rankPremium;
    private ?int $rankWl;

    public function __construct(array $data)
    {
        $this->setSubscriptions($data['subscriptions'] ?? null);
        $this->setMonthlySearches($data['monthlySearches'] ?? null);
        $this->setViews($data['views'] ?? null);
        $this->setVideosCount($data['videosCount'] ?? null);
        $this->setPremiumVideosCount($data['premiumVideosCount'] ?? null);
        $this->setWhiteLabelVideoCount($data['whiteLabelVideoCount'] ?? null);
        $this->setRankValue($data['rank_value'] ?? $data['rank'] ?? null);
        $this->setRankPremium($data['rankPremium'] ?? null);
        $this->setRankWl($data['rankWl'] ?? null);
    }

    public function setSubscriptions(int $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    public function setMonthlySearches(int $monthlySearches)
    {
        $this->monthlySearches = $monthlySearches;
    }

    public function setViews(int $views)
    {
        $this->views = $views;
    }

    public function setVideosCount(int $videosCount)
    {
        $this->videosCount = $videosCount;
    }

    public function setPremiumVideosCount(int $premiumVideosCount)
    {
        $this->premiumVideosCount = $premiumVideosCount;
    }

    public function setWhiteLabelVideoCount(int $whiteLabelVideoCount)
    {
        $this->whiteLabelVideoCount = $whiteLabelVideoCount;
    }

    public function setRankValue(int $rankValue)
    {
        $this->rankValue = $rankValue;
    }

    public function setRankPremium(int $rankPremium)
    {
        $this->rankPremium = $rankPremium;
    }

    public function setRankWl(int $rankWl)
    {
        $this->rankWl = $rankWl;
    }

    public function getSubscriptions(): ?int
    {
        return $this->subscriptions;
    }

    public function getMonthlySearches(): ?int
    {
        return $this->monthlySearches;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function getVideosCount(): ?int
    {
        return $this->videosCount;
    }

    public function getPremiumVideosCount(): ?int
    {
        return $this->premiumVideosCount;
    }

    public function getWhiteLabelVideoCount(): ?int
    {
        return $this->whiteLabelVideoCount;
    }

    public function getRankValue(): ?int
    {
        return $this->rankValue;
    }

    public function getRankPremium(): ?int
    {
        return $this->rankPremium;
    }

    public function getRankWl(): ?int
    {
        return $this->rankWl;
    }
}
