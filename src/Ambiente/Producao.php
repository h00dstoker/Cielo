<?php
/**
 * Cliente
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de crédito de várias
 * bandeiras, homologadas pela Cielo.
 * Com a integração, é possível efetuar vendas através do crédito ou
 * débito, em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Ambiente;

use MrPrompt\Cielo\Ambiente\Ambiente;

/**
 * Class Producao
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class Producao extends Ambiente
{
    /**
     * @const string
     */
    const URL = 'https://ecommerce.cbmp.com.br/servicos/ecommwsec.do';

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return static::URL;
    }
}