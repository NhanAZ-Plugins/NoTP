# NoTP

NoTP is a legacy PocketMine-MP plugin snapshot that adds a `/notp` toggle intended to block teleport commands involving a protected player. Its manifest declares plugin API 2.0.0 and credits Ghast Noob. The source uses the old `pocketmine\Player` class and dispatches permission setup commands during startup.

The manifest's permission structure and the command interception logic have not been validated on Axolotl-PM 5.x. The repository has no LICENSE file or documented grant to redistribute a modified build. No Axolotl-PM 5 port, PHAR, CI workflow or stable release is provided.

See [plugin.yml](plugin.yml) and [the historical source](src/NoTP/NoTP/Main.php). A port or release needs verified rights and a fresh security and behavior review first.
