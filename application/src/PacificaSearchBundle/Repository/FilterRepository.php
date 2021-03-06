<?php

namespace PacificaSearchBundle\Repository;

/**
 * Class FilterRepository
 *
 * Base class for repositories of types that can be included in a search filter
 */
abstract class FilterRepository extends Repository
{
    /**
     * We store names of implementing classes statically on the assumption that we aren't dynamically declaring new
     * Repository classes, because that would be insane.
     * @var string[]
     */
    private static $implementingClassNames;

    /**
     * Returns an array of the names of all classes that extend this class
     * @return string[]
     */
    public static function getImplementingClassNames()
    {
        if (self::$implementingClassNames === null) {
            // Make sure all of the classes have been declared - otherwise get_declared_classes() will only return the
            // classes that happen to have been autoloaded
            foreach (glob(__DIR__ . "/*.php") as $filename) {
                require_once($filename);
            }

            self::$implementingClassNames = [];
            foreach( get_declared_classes() as $class ) {
                if( is_subclass_of( $class, self::class ) ) {
                    self::$implementingClassNames[] = $class;
                }
            }
        }

        return self::$implementingClassNames;
    }
}