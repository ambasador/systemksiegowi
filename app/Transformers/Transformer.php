<?php
namespace App\Transformers;

abstract class Transformer
{
	/**
	 * Transformuje kolejne elementy tablicy wg abstrakcyjnej metody transform
	 * implementowanej w poszczególnych klasach rozszerzających
	 * @param  array  $items tablica wejściowa
	 * @return array        tablica wyjściowa
	 */
	public function transformCollection(array $items)
	{
		return array_map([$this, 'transform'], $items);
	}

	/**
	 * Funkcja transformująca, implementowana w klasie rozszerzającej
	 * @param  array  $items tablica wejściowa
	 */
	public abstract function transform($items);
}

