<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class MonthlyStats extends Component
{
    public User $user;

    public string $modelClass;

    public string $dateColumn = 'created_at';

    public string $title;

    public string $icon;

    public ?string $whereNotNullColumn = null;

    #[Computed]
    public function count(): int
    {
        $query = $this->modelClass::query()
            ->where('user_id', $this->user->id);

        if ($this->whereNotNullColumn) {
            $query->whereNotNull($this->whereNotNullColumn);
        }

        return $query->count();
    }

    #[Computed]
    public function percentChange(): float
    {
        $currentMonth = $this->getCountForMonth(Date::now());
        $lastMonth = $this->getCountForMonth(Date::now()->subMonth());

        if ($lastMonth === 0) {
            return $currentMonth > 0 ? 100.0 : 0.0;
        }

        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    #[Computed]
    public function sparklineData(): array
    {
        $data = [];

        for ($i = 8; $i >= 0; $i--) {
            $date = Date::now()->subMonths($i);
            $data[] = $this->getCountForMonth($date);
        }

        return $data;
    }

    public function render(): View
    {
        return view('livewire.components.monthly-stats');
    }

    protected function getCountForMonth(DateTimeInterface $date): int
    {
        $query = $this->modelClass::query()
            ->where('user_id', $this->user->id)
            ->whereYear($this->dateColumn, $date->format('Y'))
            ->whereMonth($this->dateColumn, $date->format('m'));

        if ($this->whereNotNullColumn) {
            $query->whereNotNull($this->whereNotNullColumn);
        }

        return $query->count();
    }
}
