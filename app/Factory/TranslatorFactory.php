<?php

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;

/**
 * Class TranslatorFactory.
 *
 * @author Thiago Daher
 *
 * @since   3.0.0
 *
 * @version 3.0.0
 */
class TranslatorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     *
     * @return Translator
     */
    public static function create(ContainerInterface $container): Translator
    {
        $locale = locale_get_default();
        $translator = new Translator($locale);
        $translator->addLoader('phpfile', new PhpFileLoader());
        $translator->addResource('phpfile', DATA_PATH . 'translations/' . $locale . '.php', $locale);

        return $translator;
    }
}
