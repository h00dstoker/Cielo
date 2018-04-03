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

use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Idioma\Idioma;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;
use InvalidArgumentException;

/**
 * Requisição de autorizacao de portador
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class SolicitacaoTransacao extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 1;

    /**
     * Cartão a ser utilizado
     *
     * Para modalidade Cielo, basta que o atributo Cartao::bandeira seja informado.
     *
     * @var Cartao
     */
    private $cartao;

    /**
     * URL de retorno
     *
     * @var string
     */
    private $urlRetorno;

    /**
     * Idioma a ser utilizado
     *
     * @var Idioma
     */
    private $idioma;

    /**
     * Inicializa o objeto
     *
     * @param Autorizacao $autorizacao
     * @param Transacao   $transacao
     * @param Cartao      $cartao
     * @param string      $urlRetorno
     * @param Idioma      $idioma
     */
    public function __construct(
        Autorizacao $autorizacao,
        Transacao $transacao,
        Cartao $cartao,
        string $urlRetorno,
        Idioma $idioma = null
    ) {
        if (filter_var($urlRetorno, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) == false) {
            throw new InvalidArgumentException('URL de retorno inválida.');
        }

        $this->cartao = $cartao;
        $this->urlRetorno = substr($urlRetorno, 0, 1024);
        $this->idioma = $idioma ?: new Idioma\Portugues();

        parent::__construct($autorizacao, $transacao);
    }

    /**
     * {@inheritdoc}
     */
    protected function getXmlInicial(): string
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-transacao',
            self::ID,
            Cliente::VERSAO,
            'requisicao-transacao'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $this->adicionaPortador();
        $this->adicionaTransacao();
        $this->adicionaFormaPagamento();

        $this->getEnvio()->addChild('url-retorno', (string) $this->urlRetorno);
        $this->getEnvio()->addChild('autorizar', (string) $this->transacao->getAutorizar());
        $this->getEnvio()->addChild('capturar', (string) $this->transacao->getCapturar());
        $this->getEnvio()->addChild('campo-livre', '');

        if ($this->getModalidadeIntegracao() !== Autorizacao::MODALIDADE_BUY_PAGE_LOJA) {
            return;
        }

        $numeroCartao = $this->cartao->getCartao();

        if (! empty($numeroCartao)) {
            $this->getEnvio()->addChild('bin', (string) substr($this->cartao->getCartao(), 0, 6));

            if ($this->transacao->isGerarToken() === true) {
                $this->getEnvio()->addChild('gerar-token', 'true');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function deveAdicionarTid(): bool
    {
        return false;
    }

    /**
     * Adiciona os dados do cartão à requisição
     */
    protected function adicionaPortador()
    {
        if (Autorizacao::MODALIDADE_BUY_PAGE_CIELO === $this->getModalidadeIntegracao()) {
            return;
        }

        $dadosPortador = $this->getEnvio()->addChild('dados-portador', '');

        if ( ! $this->cartao->hasToken() ) {
            $dadosPortador->addChild('numero', (string) $this->cartao->getCartao());
            $dadosPortador->addChild('validade', (string) $this->cartao->getValidade());
            $dadosPortador->addChild('indicador', (string) $this->cartao->getIndicador());

            $nomePortador = $this->cartao->getNomePortador();

            if (!empty($nomePortador)) {
                $dadosPortador->addChild('nome-portador', (string) $nomePortador);
            }

            $dadosPortador->addChild('codigo-seguranca', (string) $this->cartao->getCodigoSeguranca());
        } else {
            $dadosPortador->addChild('token', (string) $this->cartao->getToken());
        }
    }

    /**
     * Adiciona os dados da transação à requisição
     */
    protected function adicionaTransacao()
    {
        $dadosTransacao = $this->getEnvio()->addChild('dados-pedido', '');

        $dadosTransacao->addChild('numero', (string) $this->transacao->getNumero());
        $dadosTransacao->addChild('valor', (string) $this->transacao->getValor());
        $dadosTransacao->addChild('moeda', (string) $this->transacao->getMoeda());
        $dadosTransacao->addChild('data-hora', (string) $this->transacao->getDataHora()->format(\DateTime::ATOM));
        $dadosTransacao->addChild('descricao', (string) $this->transacao->getDescricao());
        $dadosTransacao->addChild('idioma', (string) $this->idioma->getIdioma());
    }

    /**
     * Adiciona os dados da forma de pagamento à requisição
     */
    protected function adicionaFormaPagamento()
    {
        $formaPgto  = $this->getEnvio()->addChild('forma-pagamento', '');

        $formaPgto->addChild('bandeira', (string) $this->cartao->getBandeira());
        $formaPgto->addChild('produto', (string) $this->transacao->getProduto());
        $formaPgto->addChild('parcelas', (string) $this->transacao->getParcelas());
    }
}
