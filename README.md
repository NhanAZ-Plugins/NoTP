# NoTP

NoTP lets each player protect themselves from other players' direct teleport commands. Use `/notp` to enable or disable protection for the current session. Protection state resets when the server restarts.

The manifest declares Axolotl-PM API 5.0.0 as the minimum API. The source is analyzed and built against pinned API 5.0.0 and 5.49.1 references; the isolated server startup check uses Axolotl-PM 5.49.1. These checks do not claim client-connected gameplay coverage.

NoTP observes API 5 `CommandEvent` and resolves registered command aliases through the server command map. Custom server aliases that expand into another command and teleport behavior implemented by other plugins may not be visible as a direct `tp` or `teleport` command. Players can still teleport themselves while their own protection is enabled. The toggle is session-only.

The source retains the historical author attribution to Ghast Noob. The repository has no license file or separate redistribution grant, so no stable release asset is published.

The build workflow uses [DevTools](https://github.com/NhanAZ/DevTools) to analyze the plugin, create its PHAR and verify the artifact.
