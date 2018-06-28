<?php
/**
 * Captura
 *
 * Dados do Captura.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Captura
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Modelos;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class Captura
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Captura
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
     * Data captura
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @SerializedName("data-hora")
     * @Type("DateTime<'Y-m-d\TH:i:s.vP'>")
     * @var datetime
     */
    private $dataHora;

    /**
     * @Type("integer")
     * @var integer
     */
    private $valor;

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
     * @return DateTime
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param DateTime $dataHora
     */
    public function setDataHora($dataHora)
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
}
