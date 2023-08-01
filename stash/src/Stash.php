<?php

declare(strict_types=1);

namespace dmyers\stash;

use dmyers\stash\StashInterface;
use peel\session\sessionInterface;
use dmyers\orange\interfaces\InputInterface;

class Stash implements StashInterface
{
    protected InputInterface $input;
    protected SessionInterface $session = null;

    protected string $stashKey = '__#stash#__';

    public function __construct(SessionInterface $session, InputInterface $input)
    {
        $this->session = $session;
        $this->input = $input;
    }

    public function push(): self
    {
        $this->session->set($this->stashKey, $this->input->copy());

        return $this;
    }

    public function apply(): bool
    {
        $stashed = null;

        if ($this->session->has($this->stashKey)) {
            $stashed = $this->session->get($this->stashKey);

            $this->session->remove($this->stashKey);

            if (is_array($stashed)) {
                $this->input->replace($stashed);
            }
        }

        return is_array($stashed);
    }

    public function __debugInfo(): array
    {
        return [
            'stashKey' => $this->stashKey,
        ];
    }
}
