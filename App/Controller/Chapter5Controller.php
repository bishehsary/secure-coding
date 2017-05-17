<?php

namespace App\Controller;

use FW\App\Validator;

class Chapter5Controller extends Chapter
{
    protected function code45()// Data Validation Strategies
    {
        $this->getCode(__FILE__, 'code45');
        $this->view->set('link', [
            ['OWASP Data Validation', 'https://www.owasp.org/index.php/Data_Validation']
        ]);
        //<code45>
        //</code45>
        $this->view->set('result', $this->view->render('sample/code45'));
    }

    protected function code46()// Sanitize with Whitelist
    {
//        return $this->code46Before();
        $this->getCode(__FILE__, 'code46');
        $this->view->set('link', [
            ['Ctype', 'http://php.net/manual/en/ref.ctype.php']
        ]);
        //<code46>
        $statement = $this->database()->query("SELECT category_id,`name` FROM category ORDER BY `name`");
        $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $this->view->set('categories', $categories);
        if ($this->request->hasPost('search')) {
            $query = [];
            $join = '';
            $film = $this->request->post('film');
            $category = (int)$this->request->post('category');
            $validCharacters = "/^[\w\d]+$/i";
            if ($film && preg_match($validCharacters, $film)/* && ctype_alnum($film)*/) {
                $query[] = " title LIKE '%{$film}%' ";
                $this->view->set('film', $film);
            }
            if ($category) {
                $found = false;
                foreach ($categories as $cat) {
                    if ($cat['category_id'] == $category) {
                        $found = true;
                        $this->view->set('category', $category);
                        break;
                    }
                }
                if ($found) {
                    $query[] = " category_id = {$category} ";
                    $join = ' LEFT JOIN film_category AS fc ON (fc.film_id=film.`film_id`) ';
                }
            }
            if (count($query) > 0) {
                $query = join(' AND ', $query);
                $query = "SELECT title,release_year FROM film {$join} WHERE {$query}";
                $statement = $this->database()->query($query);
                $this->view->set('films', $statement->fetchAll(\PDO::FETCH_ASSOC));
                $this->view->set('query', $query);
            }
        }
        //</code46>
        $this->view->set('result', $this->view->render('sample/code46'));
    }

    private function code46Before()
    {
        $statement = $this->database()->query("SELECT category_id,`name` FROM category ORDER BY `name`");
        $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $this->view->set('categories', $categories);
        if ($this->request->hasPost('search')) {
            $query = [];
            $values = [];
            $join = '';
            $film = $this->request->post('film');
            $category = (int)$this->request->post('category');
            if ($film) {
                $query[] = " title LIKE '%{$film}%' ";
//                $query[] = " title LIKE ? ";
//                $values[] = "%{$film}%";
                $this->view->set('film', $film);
            }
            if ($category) {
                $query[] = " category_id = {$category} ";
//                $query[] = " category_id = ? ";
//                $values[] = $category;
                $join = ' LEFT JOIN film_category AS fc ON (fc.film_id=film.`film_id`) ';
                $this->view->set('film', $category);
            }
            if (count($query) > 0) {
                $query = join(' AND ', $query);
                $query = "SELECT title,release_year FROM film {$join} WHERE {$query}";
                $statement = $this->database()->query($query);
//                $query = "SELECT title,release_year FROM film {$join} WHERE {$query}";
//                $statement = $this->database()->prepare($query);
//                $statement->execute($values);
                $this->view->set('films', $statement->fetchAll(\PDO::FETCH_ASSOC));
                $this->view->set('query', $query);
            }
        }
        $this->view->set('result', $this->view->render('sample/code46'));
    }

    protected function code47()// Sanitize with Blacklist
    {
        $this->getCode(__FILE__, 'code47');
        $statement = $this->database()->query("SELECT category_id,`name` FROM category ORDER BY `name`");
        $categories = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $this->view->set('categories', $categories);
        //<code47>
        if ($this->request->hasPost('search')) {
            $query = [];
            $join = '';
            $category = (int)$this->request->post('category');
            if ($category && !preg_match("/\D/", $category)) {
                $query[] = " category_id = {$category} ";
                $join = ' LEFT JOIN film_category AS fc ON (fc.film_id=film.`film_id`) ';
            }
            if (count($query) > 0) {
                $query = join(' AND ', $query);
                $query = "SELECT title,release_year FROM film {$join} WHERE {$query}";
                $statement = $this->database()->query($query);
                $this->view->set('films', $statement->fetchAll(\PDO::FETCH_ASSOC));
                $this->view->set('query', $query);
            }
        }
        //</code47>
        $this->view->set('result', $this->view->render('sample/code47'));
    }

    protected function code48()// Implement Validator
    {
        $this->getCode(__FILE__, 'code48');
        //<code48>
        if ($this->request->post('search')) {
            $nextYear = date('Y') + 1;
            $movie = $this->request->post('movie');
            $year = (int)$this->request->post('year');
//            $validation = [];
//            if ($movie && strlen($movie) >= 4 && strlen($movie) <= 8 && preg_match("/^\w[\w\d]+$/i", $movie)) {
//                $this->view->set('movie', $movie);
//            } else {
//                $validation[] = 'movie';
//            }
//            if (is_int($year) && $year >= 1900 && $year < $nextYear) {
//                $this->view->set('year', $year);
//            } else {
//                $validation[] = 'year';
//            }
            $validator = new Validator([
                ['movie' => ['minLength' => 4, 'maxLength' => 7, 'match' => "/^\w[\w\d]+$/i"]],
                ['year' => ['type' => Validator::TYPE_INT, 'min' => 1900, 'max' => $nextYear]]
            ]);
            $validation = $validator->validate($this->request->post());
            $validation = $validation === true ? [] : array_keys($validation);
            if (empty($validation)) {
                $statement = $this->database()->prepare("SELECT title,release_year FROM `film` WHERE `title` LIKE ? AND release_year>?");
                $statement->execute(["%{$movie}%", $year]);
                $this->view->set('movies', $statement->fetchAll(\PDO::FETCH_ASSOC));
            } else {
                $this->view->set('error', $validation);
            }
        }
        //</code48>
        $this->view->set('result', $this->view->render('sample/code48'));
    }
}