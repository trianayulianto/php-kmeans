<?php

namespace App\Http\Controllers;

use \App\Alternatif;
use Illuminate\Http\Request;

class HitungController extends Controller
{
    public function index()
    {
        return view('hitung.hitung_index');
    }

    public function proses_hitung(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'k' => 'required'
        ]);

        // get jumlah klaster
        $k = $request->k;

        // Mendapatkan semua data alternatif
        $datas = Alternatif::all();

        // Normalisasi data alternatif
        foreach($datas as $key => $d) {
            $q = 0;
            for ($i=0; $i < count($d->nilai_kriteria); $i++) {
                $q += pow($d->nilai_kriteria[$i], 2);
            }
            $data[$key] = $this->normaliseValue($d->nilai_kriteria, sqrt($q));
        }

        // Deklasrasi atribut
        foreach ($datas as $key => $d) {
            $attribute[$key] = $d->name;
        }

        // Proses clustering
        $kmeans = $this->kMeans($data, $k, $attribute);

        // kirim hasil clustering
        return response()->json($kmeans, 200);
    }

    function initialiseCentroids(array $data, $k) {
        $dimensions = count($data[0]);
        $centroids = array();
        $dimmax = array();
        $dimmin = array();
        foreach($data as $document) {
            foreach($document as $dim => $val) {
                if(!isset($dimmax[$dim]) || $val > $dimmax[$dim]) {
                    $dimmax[$dim] = $val;
                }
                if(!isset($dimmin[$dim]) || $val < $dimmin[$dim]) {
                    $dimmin[$dim] = $val;
                }
            }
        }
        for($i = 0; $i < $k; $i++) {
            $centroids[$i] = $this->initialiseCentroid($dimensions, $dimmax, $dimmin);
        }
        return $centroids;
    }

    function initialiseCentroid($dimensions, $dimmax, $dimmin) {
        $total = 0;
        $centroid = array();
        for($j = 0; $j < $dimensions; $j++) {
            $centroid[$j] = (rand($dimmin[$j] * 1000, $dimmax[$j] * 1000));
            $total += $centroid[$j] * $centroid[$j];
        }
        $centroid = $this->normaliseValue($centroid, sqrt($total));
        return $centroid;
    }

    function kMeans($data, $k, $attribute) {
        $centroids = $this->initialiseCentroids($data, $k);
        $mapping = array();

        while(true) {
            $new_mapping = $this->assignCentroids($data, $centroids);
            $changed = false;
            foreach($new_mapping as $documentID => $centroidID) {
                if(!isset($mapping[$documentID]) || $centroidID != $mapping[$documentID]) {
                    $mapping = $new_mapping;
                    $changed = true;
                    break;
                }
            }
            if(!$changed){
                return $this->formatResults($mapping, $data, $centroids, $attribute);
            }
            $centroids  = $this->updateCentroids($mapping, $data, $k);
        }
    }

    function formatResults($mapping, $data, $centroids, $attribute) {
        // print_r($attribute);
        $c = count($data[0])+1;
        foreach ($attribute as $key => $attr) {
            $data[$key]['attr'] = $attr;
            $data[$key]['length'] = $c;
        }
        $result  = array();
        $result['centroids'] = $centroids;
        foreach($mapping as $documentID => $centroidID) {
            $result[$centroidID][] = $data[$documentID]; //implode(',', $data[$documentID]);
        }
        return $result;
    }

    function assignCentroids($data, $centroids) {
        $mapping = array();

        foreach($data as $documentID => $document) {
            $minDist = 100;
            $minCentroid = null;
            foreach($centroids as $centroidID => $centroid) {
                $dist = 0;
                foreach($centroid as $dim => $value) {
                    $dist += abs($value - $document[$dim]);
                }
                if($dist < $minDist) {
                    $minDist = $dist;
                    $minCentroid = $centroidID;
                }
            }
            $mapping[$documentID] = $minCentroid;
        }

        return $mapping;
    }

    function updateCentroids($mapping, $data, $k) {
        $centroids = array();
        $counts = array_count_values($mapping);

        foreach($mapping as $documentID => $centroidID) {
            foreach($data[$documentID] as $dim => $value) {
                if(!isset($centroids[$centroidID][$dim])) {
                    $centroids[$centroidID][$dim] = 0;
                }
                $centroids[$centroidID][$dim] += ($value/$counts[$centroidID]);
            }
        }

        if(count($centroids) < $k) {
            $centroids = array_merge($centroids, $this->initialiseCentroids($data, $k - count($centroids)));
        }

        return $centroids;
    }

    function normaliseValue(array $vector, $total) {
        foreach($vector as &$value) {
            $value = $value/$total;
        }
        return $vector;
    }
}
