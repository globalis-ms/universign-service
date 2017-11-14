# Universign Service

[![Latest Stable Version](https://poser.pugx.org/globalis/universign-service/v/stable)](https://packagist.org/packages/globalis/universign-service)
[![Latest Unstable Version](https://poser.pugx.org/consolidation/robo/v/unstable.png)](https://packagist.org/packages/globalis/universign-service)
[![License](https://poser.pugx.org/globalis/universign-service/license)](https://packagist.org/packages/globalis/universign-service)



## Example

Scénario suivi

2 documents à signer :

* Template_1.pdf
* Template_2.pdf

2 signataires

Plan de signature, composé de 6 signatures :

* Signature Cachet serveur sur le 1 er document,
* Signature Cachet serveur sur le 2 ième document,
* Le 1 er signataire signe le 1 er document,
* Le 1 er signataire signe le 2 ième document,
* Le 2 ième signataire signe le 1 er document,
* Le 2 ième signataire signe le 2 ième document.

1. Déclaration des signataires

```php
<?php
$signer1 = new \Globalis\Universign\Request\TransactionSigner();
$signer1
    ->setFirstname('Jean')
    ->setLastname('Dupond')
    ->setPhoneNum('0999999999')
    ->setEmailAddress('jean.dupond@example.com')
    ->setSuccessURL('https://www.universign.eu/fr/sign/success/')
    ->setCancelURL('https://www.universign.eu/fr/sign/cancel/')
    ->setFailURL('https://www.universign.eu/fr/sign/failed/')
    ->setProfile('profil_vendeur');

$signer2 = new \Globalis\Universign\Request\TransactionSigner();
$signer2
    ->setFirstname('Pierre')
    ->setLastname('Martin')
    ->setPhoneNum('0888888888')
    ->setEmailAddress('pierre.martin@example.com')
    ->setSuccessURL('https://www.universign.eu/fr/sign/success/')
    ->setCancelURL('https://www.universign.eu/fr/sign/cancel/')
    ->setFailURL('https://www.universign.eu/fr/sign/failed/')
    ->setProfile('profil_client');

$signers = [$signer1, $signer2];
```

2. Déclaration des documents à signer

```php
<?php

// Signature fields
$signatureField1 = new \Globalis\Universign\Request\DocSignatureField();
$signatureField1->setPage(1)
    ->setX(100)
    ->setY(200)
    ->setSignerIndex(0)
    ->setPatternName('default')
    ->setLabel("Sur l'ensemble du template 1");

$signatureField2 = new \Globalis\Universign\Request\DocSignatureField();
$signatureField2->setPage(1)
    ->setX(350)
    ->setY(200)
    ->setSignerIndex(1)
    ->setPatternName('default')
    ->setLabel("Sur l'ensemble du template 2");

$signatureField3 = new \Globalis\Universign\Request\DocSignatureField();
$signatureField3->setPage(1)
    ->setX(100)
    ->setY(200)
    ->setSignerIndex(0)
    ->setPatternName('patternVendeur');

$signatureField4 = new \Globalis\Universign\Request\DocSignatureField();
$signatureField4->setPage(1)
    ->setX(350)
    ->setY(200)
    ->setSignerIndex(1)
    ->setPatternName('patternClient');

$signatureFieldsDoc1 = [$signatureField1, $signatureField2];
$signatureFieldsDoc2 = [$signatureField3, $signatureField4];

// Documents
$doc1 = new \Globalis\Universign\Request\TransactionDocument();
$doc1->setPath('doc/Template_2.pdf')
    ->setSignatureFields($signatureFieldsDoc1);

$doc2 = new \Globalis\Universign\Request\TransactionDocument();
$docs2->setPath('doc/Template_2.pdf')
    ->setSignatureFields($signatureFieldsDoc2);
```

3. Création de la requête et envoie de la requête

```php
<?php

$request = new \Globalis\Universign\Request\TransactionRequest();
$request->addDocument($doc1)
    ->addDocument($doc2)
    ->setSigners($signers)
    ->setHandwrittenSignatureMode(
        \Globalis\Universign\Request\TransactionRequest::HANDWRITTEN_SIGNATURE_MODE_DIGITAL
    )
    ->setMustContactFirstSigner(false)
    ->setFinalDocRequesterSent(true)
    ->setChainingMode(
        \Globalis\Universign\Request\TransactionRequest::CHAINING_MODE_WEB
    )
    ->setDescription("Demonstration de la signature Universign")
    ->setProfile("profile_demo")
    ->setCertificateTypes('simple')
    ->setLanguage('fr');

// Create XmlRpc Client
$client = new \PhpXmlRpc\Client('https://url.to.universign/end_point/');

$client->setCredentials(
    'UNIVERSIGN_USER',
    'UNIVERSIGN_PASSWORD'
);

$requester = new \Globalis\Universign\Requester($client);
// Return a \Globalis\Universign\Response\TransactionResponse (with transaction url and id)
$response = $req->requestTransaction($request);

$signatureUrl = $response->url;
$transactionId = $response->id;
```

4. Récupération des documents


```php
<?php

$response = $requester->getTransaction($transactionId);
if ($response->status === \Globalis\UniversitransactionIdgn\Response\TransactionInfo::STATUS_COMPLETED) {
    $docs = $requester->getDocuments($transactionId);
    foreach ($docs as $doc) {
        // Doc content
        $doc->content;
        // Doc file_name
        $doc->name;
    }
}
```
