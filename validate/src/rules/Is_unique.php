<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use PDO;
use Exception;
use dmyers\orange\Container;
use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Is_unique extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain a unique value.';

        list($databaseService, $tablename, $columnname) = explode('.', $options, 3);

        if (empty($databaseService) || empty($tablename) || empty($columnname)) {
            throw new Exception('In order to use the is_unique validation rule please specify a database service, tablename, column name ie. databaseService.tablename.columnName');
        }

        $container = Container::getInstance();

        if (!$container->isset($databaseService)) {
            throw new Exception('Could not locate "' . $databaseService . '" service.');
        }

        $databaseServiceConnector = $container->get($databaseService);

        if (!is_a($databaseServiceConnector, PDO)) {
            throw new Exception('"is_unique" Database Service is not a PDO connection.');
        }

        $statement = $databaseServiceConnector->prepare('SELECT `' . $columnname . '` FROM `' . $tablename . '` WHERE `' . $columnname . '` = :field LIMIT 1');

        $statement->bindValue(':field', $field, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // 0 results = does not exist
        // !todo

        return false;
    }
}
