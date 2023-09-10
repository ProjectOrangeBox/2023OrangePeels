    public function test%%KEY%%(): void
    {
        // if we throw an Exception it is not valid
        $this->expectException(ValidationFailed::class);
        
        $value = %%VALUE1%%;

        $this->%%LBASENAME%%->isValid($value,%%VALUE2%%);

        // if we get here then it's valid
        $this->assertTrue(true);
    }

