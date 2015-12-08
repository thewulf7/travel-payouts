# Travel Payouts PHP SDK

##Installation

###Composer

```
composer require thewulf7/travel-payouts
```
or add to your composer.json file, in the "require" section
```
"thewulf7/travel-payouts": "1.1.*"
```

##Usage

 First of all create main Travel object and pass your token in it 
```php
use thewulf7\travelPayouts\Travel; 

$travel = new Travel('YOUR TOKEN HERE');
```
Then you can use it get different services

###Tickets service
```php
$ticketService = $travel->getTicketService();
```
####Flights found by our users in the last 48 hours
* getLatestPrices($origin = '', $destination = '', $one_way = false, $currency = 'rub', $period_type = 'year', $page = 1, $limit = 30, $show_to_affiliates = true, $sorting = 'price', $trip_class = TicketsService::ECONOMY_CLASS, $trip_duration = 0)

####Prices for each day of the month, grouped by number of stops
* getMonthMatrix($origin, $destination, $month, $currency = 'rub', $show_to_affiliates = true)
 
####Returns prices for cities closest to the ones specified.
* getNearestPlacesMatrix($origin = '', $destination = '', $depart_date, $return_date, $currency = 'rub', $show_to_affiliates = true)
 
####Price calendar. Returns prices for dates closest to the ones specified.
* getWeekMatrix($origin, $destination, $depart_date, $return_date, $currency = 'rub', $show_to_affiliates = true)
 
####The best offers on holidays from popular cities
* getHolidaysByRoute()
 
####Returns the cheapest non-stop tickets, as well as tickets with 1 or 2 stops, for the selected route for each day of the selected month.
* getCalendar($origin, $destination, $depart_date, $return_date = '', $currency = 'rub', $calendar_type = 'departure_date', $trip_duration = 0)
 
####Returns the cheapest non-stop tickets, as well as tickets with 1 or 2 stops, for the selected route with filters by departure and return date.
* getCheap($origin, $destination, $depart_date = '', $return_date = '', $currency = 'rub')
 
####Non-stop tickets. Returns the cheapest non-stop tickets for the selected route with filters by departure and return date.
* getDirect($origin, $destination, $depart_date = '', $return_date = '', $currency = 'rub')
 
####Cheapest tickets grouped by month
* getMonthly($origin, $destination, $currency = 'rub')
 
####Returns most popular routes for selected origin
* getPopularRoutesFromCity($origin)

####Returns the routes that an airline flies and sorts them by popularity.
* getAirlineDirections($airline_code, $limit = 30)

####Example
```php
//Get flights found by our users in the last 48 hours from LED to MOW. Return array consists of thewulf7\travelPayouts\Ticket objects.
$flights = $ticketService->getLatestPrices('LED', 'MOW', false, 'rub', 'year', 1, 10);
```


