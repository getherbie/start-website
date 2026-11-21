<?php

declare(strict_types=1);

namespace startWebsite;

/**
 * Shared file list for the standalone theme export and the ZIP download in the
 * theme switcher. A child theme overlays `default`, so both paths produce the
 * same self-contained theme folder.
 */
final class ThemeFiles
{
    /**
     * @return array<string, string> relative path => absolute source file
     */
    public static function collect(string $themesDir, string $theme): array
    {
        $sources = $theme === 'default' ? ['default'] : ['default', $theme];
        $files = [];
        foreach ($sources as $source) {
            foreach (self::tree($themesDir . '/' . $source) as $relative => $absolute) {
                $files[$relative] = $absolute;
            }
        }

        return $files;
    }

    /**
     * Builds a store-only ZIP, so no PHP zip extension is required.
     *
     * @param array<string, string> $files relative path => absolute source file
     */
    public static function zip(array $files, string $prefix): string
    {
        // 1980-01-01, the earliest date a ZIP file can represent.
        $date = 0x0021;
        $local = '';
        $central = '';
        $offset = 0;
        $count = 0;

        foreach ($files as $relative => $path) {
            $name = $prefix . '/' . $relative;
            $data = (string) file_get_contents($path);
            $size = strlen($data);
            $crc = crc32($data) & 0xFFFFFFFF;

            $local .= pack(
                'VvvvvvVVVvv',
                0x04034B50, 20, 0x0800, 0, 0, $date,
                $crc, $size, $size, strlen($name), 0,
            ) . $name . $data;

            $central .= pack(
                'VvvvvvvVVVvvvvvVV',
                0x02014B50, 20, 20, 0x0800, 0, 0, $date,
                $crc, $size, $size, strlen($name), 0, 0, 0, 0, 0x81A40000, $offset,
            ) . $name;

            $offset += 30 + strlen($name) + $size;
            $count++;
        }

        $end = pack('VvvvvVVv', 0x06054B50, 0, 0, $count, $count, strlen($central), $offset, 0);

        return $local . $central . $end;
    }

    /**
     * @return array<string, string> relative path => absolute source file
     */
    private static function tree(string $dir): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[substr($file->getPathname(), strlen($dir) + 1)] = $file->getPathname();
            }
        }

        return $files;
    }
}
