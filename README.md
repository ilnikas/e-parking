# E-parking

Website platform to help users find parking spaces in cities


### Description

Managing is being done by the administrator user (special page was created). A KML file that contains data for the city must be provided by admin. <br>
From that file polygons that represent city blocks are being generated and linked with population, parking spaces available and a *demand curve* they follow. <br>
Demand curves represent what percentage of a block's (polygon's) parking spaces are taken at a specific time. <br>
Currently, three kinds of demand curves are created which are *Center* (followed by polygons located at the center of a city), *Residential* (followed by polygons located at residential areas) and *Stable*.
Below follows a description of the features of the website for a normal *user* and an *administrator*.

### Administrator features
- Load KML file <br> Admin selects and uploads kml file to server <br>
- Delete data <br> All data related to blocks (polygons) of the city gets deleted <br>
- View city data <br> Uppon load of page city data are being displayed in a map as semi-transparent grey polygons <br>
- Blocks management (not implemented yet) <br> When a block gets clicked in the map a popup opens that allows admin to view and edit number of parking spaces and demand curve that is matched to that block <br>
- Execute simulation <br> When the "Execute simulation" button is clicked modal opens to enter time of the desired simulation and also a time step in minutes. After that simulation is executed for specified time and two more button appear to execute simulation before (left button) and after (right button) the time step

### User features
- View city data <br> Uppon load of page simulation is executed for current time and results can be viewed in map <br>
- Execute simulation <br> User can execute simulation for a time of his choosing
- Search <br> User can click on the map in the place he wants to park. After that a grey marker is added in that location. When user clicks the marker he/she can enter the time they want to find a parking space and also an acceptable radius around that place to search parking spaces. After they click send, one or more blue markers appear which represent parking space reccomendations. Uppon click on those markers a popup appears which informs the user of the distance between his original marker and the parking reccomendation <br>


### Simulation
Simulation is executed for a specified time. For each block (polygon) a demand percentage is calculated using the population of the block (20% of the population is considered to always occupy the parking spaces) and demand curve data. If the final demand is between 0 and 59% then the block is colored green, if it's between 60% and 84% then it is colored yellow. Finally, if it is greater than 85% it is colored red. 
