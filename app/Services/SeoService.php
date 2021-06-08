<?php

namespace App\Services;

class SeoService
{
    private $metaBasic;
    private $facebookKey;
    private $twitterKey;
    private $constructEmail;

    // https://desarrolloweb.com/articulos/meta-tags-redes-sociales-html.html

    public function __construct()
    {
        $this->metaBasic = config('paramslist.meta:tags');
        $this->facebookKey = config('paramslist.audience:facebook');
        $this->twitterKey = config('paramslist.audience:twitter');
        $this->constructEmail = config('paramslist.construct:email');
    }

    public function json( $data ){
        $mail =  $data->only([ 'type', 'urlMail', 'action', 'btntext' ]);
        $adds = $data->only([ 'type', 'video', 'network_product', 'add', 'explain' ]);

        return serialize(json_encode([
            'mail' => $this->constructEmail( $mail ),
            'adds' => $this->addContentNetwork( $adds ),
        ]));
    }


    public function metaTag( $data ){
        $metaBasic =  $data->only([
            'metaTitle', 'metaDescription', 'metaKeywords', 'author', 'robots'
        ]);

        $facebookAudience = $data->only([
            'metaTitle', 'metaDescription', 'metaKeywords', 'author', 'robots'
        ]);

        $twitterAudience = $data->only([
            'twitter:card', 'twitter:site', 'twitter:title', 'twitter:description', 'twitter:creator', 'twitter:image:src'
        ]);

        return serialize(json_encode([
            'metaBasic' => $this->metaBasic( $metaBasic ),
            'audienceFacebook' => $this->metaAudieceFacebook( $facebookAudience ),
            'audienceTwitter' => $this->metaAudieceTwitter( $twitterAudience ),
        ]));
    }

    public function metaBasic($data)
    {
        if ($this->metaBasic) {
            return [
                'metaTitle' => $data->metaTitle,
                'metaDescription' => $data->metaDescription,
                'metaKeywords' => $data->metaKeywords,
                'author' => $data->author,
                'robots' => $data->robots,
            ];
        } else {
            return [];
        }
    }

    public function metaAudieceTwitter($data)
    {
        if ($this->twitterKey) {
            return [
                'twitter:card' => $data->twcard,
                'twitter:site' => $data->twsite,
                'twitter:title' => $data->twtitle,
                'twitter:description' => $data->twdescription,
                'twitter:creator' => $data->twcreator,
                'twitter:image:src' => $data->twimage,
            ];
        } else {
            return [];
        }
    }

    public function metaAudieceFacebook($data)
    {
        if ($this->facebookKey) {
            return [
                'og:title' => $data->fbtitle,
                'og:type' => $data->fbtype,
                'og:url' => $data->fburl,
                'og:image' => $data->fbimage,
                'og:description' => $data->fbdescription,
            ];
        } else {
            return [];
        }
    }

    public function constructEmail($data)
    {
        if ($this->constructEmail) {
            return [
                // Contenido creado para montar plantillas de envíos masivos de email.
                // Tipo de mail - plantilla
                'type' => $data->type,
                // Email raiz de respuesta
                'urlMail' => $data->urlMail,
                // Contenido base que se cargará en la plantilla
                'action' => $data->action,
                // información contenida en el botón de envío
                'btntext' => $data->btntext,
            ];
        } else {
            return [];
        }
    }

    public function addContentNetwork($data)
    {
        if ($this->constructEmail) {
            return [
                // Tipo de mail - plantilla
                'type' => $data->type,
                //Contenido para cargar elementos de tipo video
                'video' => $data->video,
                'network_product' => $data->facebook_product,
                'add' => $data->add,
                'explain' => $data->explain,
            ];
        } else {
            return [];
        }
    }
}
