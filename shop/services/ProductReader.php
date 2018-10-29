<?php

namespace shop\services;

class ProductReader
{
    /**
     * @param string $fileServer
     * @return iterable
     */
    public function readCsv(string $fileServer): iterable
    {
        $f = fopen($fileServer, 'r');
        while ($row = fgetcsv($f, 0, ';')) {
            $productRow = new ProductRow();
            $productRow->code = $row[0];
            $productRow->name = $row[1];
            $productRow->priceNew = $row[2];
            $productRow->priceOld = $row[3];
            $productRow->brandId = $row[4];
            $productRow->categoryId = $row[5];
            $productRow->description = $row[6];
            yield $productRow;
        }
        fclose($f);
    }
}