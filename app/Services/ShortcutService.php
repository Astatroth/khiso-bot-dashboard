<?php

namespace App\Services;

use App\Models\Shortcut;
use Illuminate\Support\Collection;

class ShortcutService
{
    /**
     * Return a collection of the current user's dashboard shortcuts.
     *
     * @return Collection
     */
    public function getUserShortcuts(): Collection
    {
        return Shortcut::ofUser(auth()->user()->id)->get();
    }

    /**
     * Remove a user's dashboard shortcut.
     *
     * @param int $id
     */
    public function remove(int $id): void
    {
        Shortcut::where('id', $id)->delete();
    }

    /**
     * Add or remove a user's dashboard shortcut.
     *
     * @param string     $shortcutName
     * @param string     $routeName
     * @param array|null $routeArguments
     * @return int
     */
    public function toggleShortcut(string $shortcutName, string $routeName, array $routeArguments = null): int
    {
        $shortcut = Shortcut::ofUser(auth()->user()->id)->where('route_name', $routeName)->first();

        if (is_null($shortcut)) {
            Shortcut::create([
                'user_id' => auth()->user()->id,
                'shortcut_name' => $shortcutName,
                'route_name' => $routeName,
                'route_arguments' => $routeArguments
            ]);

            return 1;
        }

        $shortcut->delete();

        return 0;
    }
}
