<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\abstract\ValidationRuleAbstract;

class allowEmpty extends ValidationRuleAbstract
{
    // this function has multiple exits!
    public function isValid(): void
    {
        // a valid object or bool value
        if (is_object($this->input) || is_bool($this->input)) {
            // already contain something so return
            return;
        }

        // a array with more than 1 entry
        if (is_array($this->input) && count($this->input) > 0) {
            // already contain something so return
            return;
        }

        // something else?
        if (is_scalar($this->input)) {
            if (trim((string)$this->input) === '') {
                // this is ok
                $this->parent->stopProcessing();
            }
        }
    }
}
