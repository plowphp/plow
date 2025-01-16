<?php

declare(strict_types=1);

namespace Plow;

use Symfony\Component\Yaml\Yaml;

/**
 * @internal
 */
class PlowBuilder
{
    private string $name = '';
    private array $triggers = [];

    public function __invoke(PlowConfig $config): void
    {
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withTriggers(array $triggers): self
    {
        $this->triggers = $triggers;

        return $this;
    }

    public function build(string $path = ''): void
    {
        $workflow = [
            'name' => $this->formatName(),
            'on' => $this->formatTriggers(),
            'jobs' => [
                'ci' => [

                ]
            ],
        ];

        $yaml = Yaml::dump($workflow,4, 2);
        $yaml = str_replace("'", '', $yaml);

        $pathFile = __DIR__ . $path;
        $fullPath = $pathFile . str_replace(' ', '-', strtolower($this->name)) . '.yml';

        file_put_contents($fullPath, $yaml);
    }

    private function formatTriggers(): array|string
    {
        if (count($this->triggers) === 1 && is_array($this->triggers[0])) {
            return $this->triggers[0];
        }

        return $this->triggers;
    }

    private function formatName(): string
    {
        return ucfirst($this->name);
    }
}
