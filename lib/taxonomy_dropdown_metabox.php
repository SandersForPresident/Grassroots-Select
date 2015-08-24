<?php
namespace GrassrootsSelect\TaxonomyDropdownMetabox;

function dropdown_metabox($post, $box) {
  $taxonomySlug = $box['args']['taxonomy'];
  $postTaxonomy = wp_get_object_terms($post->ID, $taxonomySlug);
  if (!empty($postTaxonomy)) {
    $selectedTaxonomy = $postTaxonomy[0];
  }
  ?>
  <div id="taxonomy-<?php echo $taxonomySlug; ?>" class="acf-taxonomy-field categorydiv">
    <?php
      wp_dropdown_categories(array(
        'taxonomy' => $taxonomySlug,
        'hide_empty' => false,
        'name' => "tax_input[{$taxonomySlug}][]",
        'selected' => !empty($selectedTaxonomy) ? $selectedTaxonomy->term_id : null,
        'orderby' => 'name',
        'hierarchical' => false,
        'show_option_none' => '&mdash;'
      ));
    ?>
  </div>
  <?php
}
