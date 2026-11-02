<?php
declare(strict_types=1);

namespace App\Models;

class Setting extends BaseModel
{
    protected string $table = 'site_settings';

    public function getAllGrouped(): array
    {
        $all = $this->all('group_name ASC, id ASC');
        $grouped = [];
        foreach ($all as $item) {
            $grouped[$item['group_name']][] = $item;
        }
        return $grouped;
    }

    public function get(string $key, mixed $default = ''): mixed
    {
        $existing = $this->findBy('setting_key', $key);
        return $existing ? $existing['setting_value'] : $default;
    }

    public function set(string $key, mixed $value): void
    {
        $existing = $this->findBy('setting_key', $key);
        if ($existing) {
            $this->update($existing['id'], ['setting_value' => (string)$value]);
        } else {
            $this->create([
                'setting_key' => $key,
                'setting_value' => (string)$value,
                'setting_label' => ucwords(str_replace('_', ' ', $key)),
                'group_name' => 'custom',
                'setting_type' => 'text'
            ]);
        }
    }
}

