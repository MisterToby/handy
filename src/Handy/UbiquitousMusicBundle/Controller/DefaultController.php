<?php

namespace Handy\UbiquitousMusicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Handy\UbiquitousMusicBundle\Entity\MusicItem;

use \SplStack;

class DefaultController extends Controller {
    public function streamAction() {
        $file = "/var/music/Guns N Roses - Greatest Hits (2CDs) [www.lokotorrents.com][mp3]/Disc 1/01.Welcome To The Jungle.mp3";

        header('Content-Type: audio/mpeg');
        header('Expires: Thu, 01 Jan 1970 00:00:00 GMT\r\n');
        header('Content-Length: ' . filesize($file));
        readfile($file);

        exit ;
    }

    public function getMusicDirectoryAction() {
        $em = $this -> getDoctrine() -> getManager();
        $request = Request::createFromGlobals();
        $post = $request -> request -> all();
        $post = $request -> query -> all();

        $directory = $em -> find('UbiquitousMusicBundle:MusicItem', $post['id']);

        $qb = $em -> createQueryBuilder();
        $qb -> select('mui');
        $qb -> from('UbiquitousMusicBundle:MusicItem', 'mui');
        $qb -> where("mui.muiMuiParent = {$post['id']}");

        $query = $qb -> getQuery();
        $items = $query -> getResult();

        return $this -> render('UbiquitousMusicBundle:Default:get_music_directory.html.twig', array('directory' => $directory, 'items' => $items));
    }

    public function getStarredAction() {
        return $this -> render('UbiquitousMusicBundle:Default:get_starred.html.twig', array());
    }

    public function getIndexesAction() {
        $em = $this -> getDoctrine() -> getManager();

        $qb = $em -> createQueryBuilder();
        $qb -> select('mui.id, mui.muiName, SUBSTRING(mui.muiName, 1, 1) AS firstCharacter');
        $qb -> from('UbiquitousMusicBundle:MusicItem', 'mui');
        $qb -> where('mui.muiMuiParent IS NULL');

        $query = $qb -> getQuery();
        $result = $query -> getArrayResult();

        $index = array();
        foreach ($result as $key => $value) {
            $index[$value['firstCharacter']][] = $value;
        }

        return $this -> render('UbiquitousMusicBundle:Default:get_indexes.html.twig', array('index' => $index));
    }

    public function getMusicFoldersAction() {
        return $this -> render('UbiquitousMusicBundle:Default:get_music_folders.html.twig', array());
    }

    public function indexAction($name) {
        return $this -> render('UbiquitousMusicBundle:Default:index.html.twig', array('name' => $name));
    }

    public function indexMusicAction() {
        $em = $this -> getDoctrine() -> getManager();

        $musicPath = '/var/music/';

        $stack = new SplStack();
        $stack -> push(array('path' => $musicPath, 'entity' => NULL));

        while (!$stack -> isEmpty()) {
            $item = $stack -> pop();
            $files = scandir($item['path']);
            foreach ($files as $key => $value) {
                if ($value != '.' && $value != '..') {
                    $newPath = "{$item['path']}$value";
                    if (is_dir($newPath)) {
                        // echo $newPath . "/\n<br>";

                        $entity = new MusicItem();
                        $entity -> setMuiName($value);
                        $entity -> setMuiIsDirectory(TRUE);
                        $entity -> setMuiMuiParent($item['entity']);
                        $em -> persist($entity);

                        $stack -> push(array('path' => "$newPath/", 'entity' => $entity));
                    } else if (stripos($value, '.mp3') !== FALSE) {
                        echo $newPath . "\n<br>";

                        $entity = new MusicItem();
                        $entity -> setMuiName($value);
                        $entity -> setMuiIsDirectory(FALSE);
                        $entity -> setMuiMuiParent($item['entity']);
                        $em -> persist($entity);
                    }
                }
            }
        }

        $em -> flush();

        return new Response('');
    }

}
