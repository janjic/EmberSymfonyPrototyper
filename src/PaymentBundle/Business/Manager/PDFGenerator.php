<?php
namespace PaymentBundle\Business\Manager;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class PDFGenerator
 * @package PaymentBundle\Business\Manager
 */
class PDFGenerator
{

    /** @var bool  */
    private $addDefaultConstructorArgs = true;

    /**
     * Get an instance of mPDF class
     * @param array $constructorArgs arguments for mPDF constror
     * @return \mPDF
     */
    public function getMpdf($constructorArgs = array())
    {
        $allConstructorArgs = $constructorArgs;
        if ($this->getAddDefaultConstructorArgs()) {
            $allConstructorArgs = array_merge($allConstructorArgs, array('utf-8', 'A4'));
        }
        $reflection = new \ReflectionClass('\mPDF');
        $mpdf = $reflection->newInstanceArgs($allConstructorArgs);
//        $mpdf->showImageErrors = true;

        return $mpdf;
    }

    /**
     * @param mixed $html
     * @param array $argOptions
     *
     * @return mixed
     */
    private function getMPDFGenerator($html, array $argOptions = array())
    {
        //Calculate arguments
        $defaultOptions = array(
            'constructorArgs' => array(),
            'writeHtmlMode' => null,
            'writeHtmlInitialise' => null,
            'writeHtmlClose' => null,
            'outputFilename' => null,
            'outputDest' => null,
            'mpdf'=>null
        );

        $options = array_merge($defaultOptions, $argOptions);
        extract($options);
        if (null == $mpdf) {
            $mpdf = $this->getMpdf($constructorArgs);
        }

        //Add argguments to AddHtml function
        $writeHtmlArgs = array($writeHtmlMode, $writeHtmlInitialise, $writeHtmlClose);
        $writeHtmlArgs = array_filter($writeHtmlArgs, function($x) {
            return !is_null($x);
        });
        $writeHtmlArgs['html'] = $html;

        call_user_func_array(array($mpdf, 'WriteHTML'), $writeHtmlArgs);

        //Add arguments to Output function
        $outputArgs = array($outputFilename, $outputDest);
        $outputArgs = array_filter($outputArgs, function($x) {
            return !is_null($x);
        });

        return array($mpdf, $outputArgs);

    }

    /**
     * @param mixed $html
     * @param array $argOptions
     *
     * @return mixed
     */
    public function generatePdf($html, array $argOptions = array())
    {
        $args= $this->getMPDFGenerator($html, $argOptions);
        $content = call_user_func_array(array($args[0], 'Output'), $args[1]);
        return $content;
    }

    /**
     * @param mixed $html
     * @param array $argOptions
     *
     * @return Response
     */
    public function generatePdfResponse($html, array $argOptions = array())
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');

        $content = $this->generatePdf($html, $argOptions);
        $response->setContent($content);

        return $response;
    }

    /**
     * @param mixed $val
     *
     * @return $this
     */
    public function setAddDefaultConstructorArgs($val)
    {
        $this->addDefaultConstructorArgs = $val;

        return $this;
    }

    /**
     * @param string $fileName
     * @param string $mode
     * @param string $htmlTemplate
     * @param array  $argOptions
     * @return string
     */
    public function saveToFile($fileName, $mode, $htmlTemplate, $argOptions = array())
    {
        $argOptions = array_merge($argOptions, array('outputFilename' => $fileName, 'outputDest'=> $mode));
        $args= $this->getMPDFGenerator($htmlTemplate, $argOptions);
        $content = call_user_func_array(array($args[0], 'Output'), $args[1]);

        return $content;
    }

    /**
     * @return bool
     */
    public function getAddDefaultConstructorArgs()
    {
        return $this->addDefaultConstructorArgs;
    }

}