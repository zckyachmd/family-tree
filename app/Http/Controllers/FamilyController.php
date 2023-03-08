<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Contracts\View\View;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Family $family): View
    {
        // Data to be passed to the view
        $data = [
            'title'     => 'Family Tree',
            'families'  => $this->buildTreeHtml($family->buildFamilyTree()),
        ];

        // Return the view
        return view('index', $data);
    }

    /**
     * Build the HTML representation of the family tree.
     *
     * @param  array $tree
     * @return string
     */
    private function buildTreeHtml(array $tree): string
    {
        // Check if the tree is empty
        if (empty($tree)) {
            return '';
        }

        // Build the HTML
        $html = '<ul>';

        // Loop through the tree
        foreach ($tree as $node) {
            // Check gender and set the class
            $gender = $node['gender'] == 'male' ? 'bg-primary text-light' : 'bg-danger text-light';

            // Create the node
            $html .= '<li>';
            $html .= '<button class="' . $gender . ' btn-edit" data-id="' . $node['id'] . '">' . $node['name'] . '</button>';

            // Check if the node has children
            if (isset($node['children']) && count($node['children']) > 0) {
                // Panggil diri sendiri untuk memproses children
                $html .= $this->buildTreeHtml($node['children']);
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        // Return the HTML
        return $html;
    }
}
