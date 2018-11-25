<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ArticleController extends AbstractController
{
	/**
	 * @Route("/", name="app_homepage")
	 */
    public function homepage(){
		return $this->render('article/homepage.html.twig');
	}

	/**
	 * @Route("/task/{slug}", name="show_article")
	*/
	public function show($slug, AdapterInterface $cache){
		
		$comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        $articleContent = 'this aaa is a test';

        $cacheData = $cache->getItem('mardown'.md5($articleContent));

        if(!$cacheData->isHit()){
        	$cacheData->set($articleContent);
        	$cache->save($cacheData);
        }
        $articleContent = $cacheData->get();

		return  $this->render('article/show.html.twig', [
					'urltitle' => ucwords(str_replace('-', ' ', $slug)),
					'comments' => $comments,
					'articleContent' => $articleContent,
					'slug' => $slug
				]);

		// return new Response(sprintf(
		// 		'this is my route: %s', $slug
		// 	)); 
	}

	/**
	 * @Route("/task/{slug}/heart", name="article_toogle", methods = {"POST"})
	*/	
	public function toogleArticleLike($slug, LoggerInterface $logger){
		// return new Response(json_encode(['heart' => 5]));
		$logger->info('Article is being hearted');
		return new JsonResponse(['heart' => 1]);

	}

}

?>