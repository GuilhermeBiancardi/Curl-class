# Curl-class

## Inclusão da Classe

```php
    include_once "diretorio/Curl.class.php";
```

## Chamada da Classe

```php
    $curl = new Curl();
```

### Requisição Simples ou GET

```php
    $curl = new Curl();
    // Simples Request
    $curl->setUrl("http://URL_REQUEST");
    // GET Request
    $curl->setUrl("http://URL_REQUEST?nome=Guilherme&sobrenome=Biancardi");
    $resposnse = $this->getContent();
```

### Requisição POST

```php
    $curl = new Curl();
    $curl->setUrl("http://URL_REQUEST");
    $curl->setPostValues(Array(
        "key" => "value",
        "nome" => "Guilherme",
        "sobrenome" => "Binacardi"
    ));
    $resposnse = $this->getContent();
```
O Retorno da requisição ficará armazenado na variável **$response**, podendo ser tratado da forma que preferir.

Aproveitem!
