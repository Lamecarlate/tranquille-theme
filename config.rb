# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = ""
sass_dir = "sass"
images_dir = "images"
javascripts_dir = "js"
fonts_dir = "fonts"

# gestion des environnements
if environment == :production
  output_style = :compressed
else
  output_style = :expanded
  sass_options = { :debug_info => true }
end

# Désactiver l'ajout du cache buster sur les images appelées via la fonction image-url().
asset_cache_buster :none

relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false
