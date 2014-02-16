/**
 * Module dependencies.
 */

var express = require('express'),
    app = module.exports = express.createServer();

// MongoDB
var mongoose = require('mongoose'),
    db = mongoose.connect('mongodb://127.0.0.1/example'),
    //create the movie Model using the 'movies' collection as a data-source
    movieModel = mongoose.model('movies', new mongoose.Schema({
        title: String,
        year: Number
    }));

// Configuration
app.configure(function () {
    app.set('views', __dirname + '/views');
    app.set('view engine', 'jade');
    app.use(express.bodyParser());
    app.use(express.methodOverride());
    app.use(app.router);
    app.use(express.static(__dirname + '/public'));
});

app.configure('development', function () {
    app.use(express.errorHandler({
        dumpExceptions: true,
        showStack: true
    }));
});

app.configure('production', function () {
    app.use(express.errorHandler());
});

// Routes
app.get('/', function (req, res) {
    res.redirect('/index.html');
});

app.get('/movies', function (req, res) {
    movieModel.find({}, function (err, movies) {
        res.contentType('json');
        res.json({
            success: true,
            data: movies
        });
    });
});

app.listen(3000);
console.log("Express server listening on port %d in %s mode", app.address().port, app.settings.env);
