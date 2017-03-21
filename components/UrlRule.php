<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.02.2017
 * Time: 22:39
 */

namespace seiweb\inlinecontent\components;



use seiweb\inlinecontent\models\Page;
use yii\base\Object;
use yii\web\UrlRuleInterface;

class UrlRule extends Object implements UrlRuleInterface
{

	public function createUrl($manager, $route, $params)
	{
		return false;
		print_r($params);
		if ($route === 'car/index') {
			if (isset($params['manufacturer'], $params['model'])) {
				return $params['manufacturer'] . '/' . $params['model'];
			} elseif (isset($params['manufacturer'])) {
				return $params['manufacturer'];
			}
		}
		return false;  // данное правило не применимо
	}

	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();
		//перенаправляем на страницу, которая установлена главной
		if($pathInfo=='') return ['/inlinecontent/frontend/view',['full_slug'=>null]];

		$routes = [];
		foreach(Page::find()->andWhere('depth>0')->asArray()->all() as $page)
			$routes[$page['full_slug']]= $page['route']?
				[
					'route'=>$page['route'],
					'params'=>$page['route_params'],
					'page_title'=>$page['title'],
					] : null;

		if (array_key_exists($pathInfo,$routes) && $routes[$pathInfo]!='')
		{
			$route = $routes[$pathInfo]['route'];
			$params = $routes[$pathInfo]['params'];
			$params = explode('&',$params);
			$p = [];
			foreach ($params as $v) {
				$v = explode('=',$v);
				$p[$v[0]] = $v[1];
			}
			$p['page_title']=$routes[$pathInfo]['page_title'];
			return [$route,$p];
		}




		if(array_key_exists($pathInfo,$routes))
			return ['/inlinecontent/frontend/view',['full_slug'=>$pathInfo]];

		//это не страница, значит обрабатываем правила дальше
		return false;

		if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
			// Ищем совпадения $matches[1] и $matches[3]
			// с данными manufacturer и model в базе данных
			// Если нашли, устанавливаем $params['manufacturer'] и/или $params['model']
			// и возвращаем ['car/index', $params]
		}
		return false;  // данное правило не применимо
	}
}