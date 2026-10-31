<?php

namespace App\Legacy;

/**
 * Access the system configuration
 *
 * @property bool hasDatabase
 * @property string title
 * @property string websiteUrl
 * @property string logoFileName
 * @property string logo
 * @property string clientLogo
 * @property string severLogo
 * @property string absoluteLogo
 * @property string emailLogo
 * @property string themeColor
 */
class LegacyConfig
{
    use Singleton;

    private const CONFIG_KEYS = [
        'name' => 'app.name',
        'fullName' => 'custom.meta_data.full_name',
        'description' => 'custom.meta_data.description',
        'shortDescription' => 'custom.meta_data.short_description',
        'timezone' => 'app.timezone',
        'languages' => 'app.locales',
        'themeColor' => 'custom.meta_data.default_color_scheme',
        'domain' => 'app.url',
        'websiteUrl' => 'app.url',
    ];

    private function __construct() {}

    public function __get($property)
    {
        if (isset(self::CONFIG_KEYS[$property])) {
            return config(self::CONFIG_KEYS[$property]);
        }

        $method = 'get'.ucfirst($property);

        return method_exists($this, $method) ? $this->$method() : null;
    }

    /**
     * Get methods
     */
    private function getHasDatabase()
    {
        return true;
    }

    private function getDefaultLanguage()
    {
        return config('app.fallback_locale');
    }

    private function getLogoFileName()
    {
        return 'logo-preview.jpg';
    }

    private function getLogo()
    {
        return LOGO_DIR.$this->logoFileName;
    }

    private function getClientLogo()
    {
        if (file_exists(server_path($this->logo))) {
            return client_path($this->logo);
        } elseif (file_exists(server_path($this->logo))) {
            return public_client_path($this->logo);
        } else {
            return null;
        }
    }

    private function getSeverLogo()
    {
        if (file_exists($file = server_path($this->logo))) {
            return $file;
        } elseif (file_exists($file = server_path($this->logo))) {
            return $file;
        } else {
            return null;
        }
    }

    private function getAbsoluteLogo()
    {
        return $this->websiteUrl.$this->logoImage;
    }

    private function getEmailLogo()
    {
        if (file_exists(server_path($file = LOGO_DIR.'logo-email.png'))) {
            return public_client_url($file);
        } else {
            return $this->absoluteLogo;
        }
    }

    private function getCookiesWarning()
    {
        return false;
    }

    private function getLoggedRedirectUrl()
    {
        return '/';
    }
}
