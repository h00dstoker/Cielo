<?php
/**
 * Autorizacao
 *
 * Dados de Autorizacao.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Autorizacao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Modelos;

use DateTime;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class Autorizacao
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Autorizacao
{
    /**
     * @Type("integer")
     * @var integer
     */
    private $codigo;

    /**
     * @Type("string")
     * @var string
     */
    private $mensagem;

    /**
     * Data Autorizacao
     *
     * @SerializedName("data-hora")
     * @Type("string")
     * @var string
     */
    private $dataHora;

    /**
     * @Type("integer")
     * @var integer
     */
    private $valor;

    /**
     * @SerializedName("lr")
     * @Type("integer")
     * @var integer
     */
    private $lrCod;

    /**
     * @Type("integer")
     * @var integer
     */
    private $arp;

    /**
     * @Type("integer")
     * @var integer
     */
    private $nsu;

    /**
     * Construtor
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return string
     */
    public function getDataHora(): string
    {
        return $this->dataHora;
    }

    /**
     * @param string $dataHora
     */
    public function setDataHora(string $dataHora): void
    {
        $this->dataHora = $dataHora;
    }


    /**
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return int
     */
    public function getLrCod(): int
    {
        return $this->lrCod;
    }

    /**
     * @param int $lrCod
     */
    public function setLrCod(int $lrCod): void
    {
        $this->lrCod = $lrCod;
    }

    /**
     * @return int
     */
    public function getArp()
    {
        return $this->arp;
    }

    /**
     * @param int $arp
     */
    public function setArp($arp)
    {
        $this->arp = $arp;
    }

    /**
     * @return int
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @param int $nsu
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
    }
}
