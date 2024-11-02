# Release Notes

## [Unreleased](https://github.com/lazervel/dotenv/compare/v3.0.0...v3.0.0)

## [v3.0](https://github.com/lazervel/dotenv/releases/tag/v3.0.0) - 02 November 2024
- Added `required()` method use to `Dotenv::process(__DIR__, 'yourconfig.env')->required($variables);` develop by [@shahzadamodassir](https://github.com/shahzadamodassir).
- Added `ifPresent()` method use to `Dotenv::process(__DIR__, 'yourconfig.env')->ifPresent($variables);` develop by [@shahzadamodassir](https://github.com/shahzadamodassir).
- [BC BREAK] Since v3.x, Due to significant updates in the library, all previous configurations may no longer work as expected. Users will need to reconfigure their settings to align with the new structure and behavior introduced in this update.
- Review the updated documentation for `Dotenv::process(__DIR__, 'yourconfig.env');` to understand the new behavior.
- Ensure that any calls to these methods are updated to accommodate these changes.

**Suggest:** We allow to use PHP `dotenv` library version from [3.0.1](https://github.com/lazervel/dotenv/releases/tag/v3.0.1) to [latest](https://github.com/lazervel/dotenv/releases/latest) Recomended [latest](https://github.com/lazervel/dotenv/releases/latest) version for best performance.
