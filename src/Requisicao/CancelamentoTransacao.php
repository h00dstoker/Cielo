<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
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

namespace MrPrompt\Cielo\Requisicao;

use MrPrompt\Cielo\Cliente;

/**
 * Requisição de cancelamento de transação
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class CancelamentoTransacao extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 4;

    /**
     * {@inheritdoc}
     */
    protected function getXmlInicial(): string
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-cancelamento',
            self::ID,
            Cliente::VERSAO,
            'requisicao-cancelamento'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $valor = $this->transacao->getValor();
        
        if (!empty($valor)) {
            $this->getEnvio()->addChild('valor', (string) $valor);
        }
    }
}
