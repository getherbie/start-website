<?php

declare(strict_types=1);

namespace startWebsite\Commands;

use herbie\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Materialises a theme as a standalone folder. The source themes share files
 * through `themeParent`; the export overlays the chosen theme on `default` so the
 * result can be copied 1:1 into another project without a parent theme.
 */
final class ExportThemeCommand extends Command
{
    protected static $defaultName = 'export-theme';
    protected static $defaultDescription = 'Exports a theme as a standalone folder';

    public function __construct(private readonly Config $config)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Copies a theme and the shared files from `default` to dist/themes. Use --all to export every theme listed in site.json.')
            ->addArgument('theme', InputArgument::OPTIONAL, 'Theme name')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Export every theme from site.json');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $siteData = json_decode((string) file_get_contents($this->config->getAsString('paths.data') . '/site.json'), true);
        $knownThemes = is_array($siteData['themes'] ?? null) ? $siteData['themes'] : [];

        $theme = $input->getArgument('theme');
        if ($input->getOption('all')) {
            $themes = $knownThemes;
        } elseif (is_string($theme) && $theme !== '') {
            $themes = [$theme];
        } else {
            $output->writeln('<error>Provide a theme name or --all.</error>');
            return Command::INVALID;
        }

        $sourceDir = $this->config->getAsString('paths.themes');
        $targetDir = $this->config->getAsString('paths.app') . '/dist/themes';

        foreach ($themes as $name) {
            if (!in_array($name, $knownThemes, true)) {
                $output->writeln(sprintf(
                    '<error>Unknown theme: %s. Known themes: %s</error>',
                    $name,
                    implode(', ', $knownThemes),
                ));
                return Command::FAILURE;
            }
            if (!is_dir($sourceDir . '/' . $name)) {
                $output->writeln(sprintf('<error>Missing theme directory: site/themes/%s</error>', $name));
                return Command::FAILURE;
            }

            $target = $targetDir . '/' . $name;
            if (is_dir($target)) {
                $output->writeln(sprintf('<error>Refusing to overwrite existing export: dist/themes/%s</error>', $name));
                return Command::FAILURE;
            }

            if (!$this->copyTree($sourceDir . '/default', $target)
                || ($name !== 'default' && !$this->copyTree($sourceDir . '/' . $name, $target))) {
                $output->writeln(sprintf('<error>Could not export theme: %s</error>', $name));
                return Command::FAILURE;
            }

            $output->writeln(sprintf('Exported %s to dist/themes/%s', $name, $name));
        }

        return Command::SUCCESS;
    }

    private function copyTree(string $from, string $to): bool
    {
        if (!is_dir($to) && !mkdir($to, 0777, true) && !is_dir($to)) {
            return false;
        }

        foreach (scandir($from) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $source = $from . '/' . $entry;
            $target = $to . '/' . $entry;

            if (is_dir($source)) {
                if (!$this->copyTree($source, $target)) {
                    return false;
                }
            } elseif (!copy($source, $target)) {
                return false;
            }
        }

        return true;
    }
}

return ExportThemeCommand::class;
