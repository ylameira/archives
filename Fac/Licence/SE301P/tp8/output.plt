# Sortie
set terminal png size 400,250
set output '3dsample.png'
# Paramétrage
set samples 20
set isosamples 20
set hidden3d
# Dessin de la courbe
splot [-3:3] [-2:2] 1 / (x*x + y*y + 1)

