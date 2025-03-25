<?php

namespace App\Console\Commands;

use App\Tibia\Data\Guild\MemberData;
use App\Tibia\Data\Guilds\GuildData;
use App\Tibia\Data\World\OnlinePlayerData;
use App\Tibia\Data\Worlds\WorldData;
use App\Tibia\TibiaDataApi\Resources\GuildResource;
use App\Tibia\TibiaDataApi\Resources\WorldResource;
use Exception;
use Illuminate\Console\Command;
use Storage;

class FetchCharacterNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-character-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        WorldResource $rWorld,
        GuildResource $rGuild,
    ) {
        $worlds = $rWorld->all()->worlds->regularWorlds;

        $guilds = collect();

        $this->info('Fetching guilds from '.$worlds->count().' worlds');
        $this->withProgressBar($worlds, function (WorldData $world) use ($rGuild, &$guilds) {
            $worldGuilds = $rGuild->fromWorld($world->name)->guilds->active;
            $guilds = $guilds->merge($worldGuilds);
        });
        $this->newLine();

        $players = collect();

        $this->info('Fetching players from '.$guilds->count().' guilds');
        $this->withProgressBar($guilds, function (GuildData $guild) use ($rGuild, &$players) {
            try {
                $guildMembers = $rGuild->get($guild->name)->guild->members;
            } catch (Exception) {
                $this->error('Error fetching guild : '.$guild->name);

                return;
            }

            $players = $players->merge($guildMembers->map(fn (MemberData $member) => $member->name));
        });
        $this->newLine();

        $this->info('Fetching players from '.$worlds->count().' worlds');
        $this->withProgressBar($worlds, function (WorldData $world) use ($rWorld, &$players) {
            $worldOnline = $rWorld->get($world->name)->world->onlinePlayers;
            $players = $players->merge($worldOnline->map(fn (OnlinePlayerData $player) => $player->name));
        });
        $this->newLine();

        Storage::write('charnames.json', json_encode($players->unique()->all(), JSON_PRETTY_PRINT));
    }
}
