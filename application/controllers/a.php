!function($){
    
    var defaults = {
        cols: 8,
        rows: 8,
        bombs: 10
    };
    
    var Cell = function Cell(x,y,isBomb) {
        this.x = x;
        this.y = y;
        this.isBomb = isBomb;
        
        this.activeNeighbours = 0;
        this.neighbours = [];
        this.revealed = false;
        this._mark = "";
        this.id = y + "-" + x;
    };
    Cell.prototype.setValue = function(value){
        var el = $("#minesweeper").find("td[data-index='"+this.id+"']");
        el.removeClass('mark').html(value);
        switch(value) {
            case "!":
            case "?":
                el.addClass('mark');
                break;
            case "X":
                el.addClass('bomb');
                break;
        }
        return this;
    };
    Cell.prototype.addNeighbour = function(neighbour){
        this.neighbours.push(neighbour);
        this.activeNeighbours += (neighbour.isBomb ? 1 : 0);
        return this;
    };
    Cell.prototype.getNeighbours = function(neighbour){
        return this.neighbours;
    };
    Cell.prototype.isRevealed = function(neighbour){
        return this.revealed || this.isBomb;
    };
    Cell.prototype.reveal = function(fn, context){
        if(this.isBomb) {
            return ;
        }
        this.revealed = true;
        this.setValue(this.activeNeighbours);
        if(this.activeNeighbours === 0) {
            $.each(this.getNeighbours(), function(i, neighbour){
                if(!neighbour.isRevealed()) {
                    neighbour.reveal(fn, context);
                }
            });
        };
        fn.call(context);
    };
    Cell.prototype.mark = function() {
        if(this.revealed) {
            return ;
        }
        switch(this._mark) {
            case "":
                this._mark = "?";
                break;
            case "?":
                this._mark = "!";
                break;
            case "!":
                this._mark = "";
                break;
        }
        this.setValue(this._mark || "&nbsp;");
        return this;
    };
    
    var Board = {
        board: [],
        bombStack: {},
        reset: function(rows, colls, numBombs) {
            var x, y, row, self = this;
            
            this.colls = colls;
            this.rows = rows;
            
            this.board = []; // reset the board
            this.bombStack = {}; // reset our current bomb stack
            
            this.generateBombs(numBombs);
            
            // build the data structure
            for(y=0; y<this.rows; y++) {
                row = [];
                this.board.push(row);
                for(x=0; x<this.colls; x++) {
                    var isBomb = this.bombStack[y] && this.bombStack[y][x];
                    row.push(new Cell(x,y,isBomb));
                }
            }
            
            // assign neightbour reference for each cell
            this.traversCells(function(cell) {
                var neighbours = self.calcNeighbours(cell);
                $.each(neighbours, function(key, value){
                    cell.addNeighbour(value);
                });
            });
            
            return this;
        },
        // run a callback on each cell in the board
        traversCells: function(fn) {
            var x, y;
            for(y=0; y<this.rows; y++){
                for(x=0; x<this.colls; x++){
                    fn(this.getCell(x, y));
                }
            }
        },
        draw: function(){
            var x, y, tr, td, tbody = $('<tbody>');
            for(y=0; y<this.rows; y++) {
                tr = $('<tr>');
                for(x=0; x<this.colls; x++) {
                    td = $('<td data-index="'+y+'-'+x+'">').html("&nbsp;");
                    tr.append(td);
                }
                tbody.append(tr);
            }
            Game.over = false;
            $("#minesweeper").empty().html(tbody);
            return this;
        },
        validate: function(){
            var numActive = 0;
            this.traversCells(function(cell) {
                numActive += cell.isRevealed() ? 0 : 1;
            });
            if(!numActive) {
                this.checkBombs();
                Game.complete(true);
            }
        },
        reveal: function(cell, passive){
            cell.reveal(this.validate, this);
            if(cell.isBomb) {
                this.checkBombs();
                Game.complete();
            }
        },
        getCell: function(x,y) {
            return this.board[y][x];
        },
        generateBombs: function(numBombs) {
            var i;
            for(i=0; i<numBombs; i++) {
                this.generateBomb();
            }
        },
        generateBomb: function() {
            var x = Math.floor(Math.random() * this.colls);
            var y = Math.floor(Math.random() * this.rows);
            if(this.bombStack[y] && this.bombStack[y][x]) { // do not allow duplicates
                return this.generateBomb();
            }
            this.bombStack[y] = this.bombStack[y] || {};
            this.bombStack[y][x] = true;
        },
        checkBombs: function(){
            this.traversCells(function(cell) {
                if(cell.isBomb) {
                    cell.setValue("X");
                }
            });
        },
        getCellByEvent: function(e) {
            var cords = $(e.target).attr('data-index').split('-');
            var y = +cords[0], x=+cords[1];
            return this.getCell(x, y);
        },
        calcNeighbours: function(cell) {
            var i, j, data = [], x = cell.x, y = cell.y;
            for( i=y-1; i<=y+1; i++ ) {
                if(i<0 || i>=this.rows)  continue;
                for(j=x-1; j<=x+1; j++) {
                    if(j<0 || j>=this.colls) continue;
                    if(x===j && y===i) continue;
                    data.push(this.getCell(j,i));
                }
            }
            return data;
        }
    };
    
    var Game = {
        over: false,
        complete: function(win) {
            $('#status').html("Game Over, You " + (win ? "Won" : "Lost") + "!");
            if(win) {
                $('#status').addClass("alert-success").removeClass("alert-info").removeClass("alert-error");
            }
            else {
                $('#status').removeClass("alert-success").removeClass("alert-info").addClass("alert-error");
            }
            var el = $("#minesweeper"); 
            el.removeClass('active');
            if(!win) {
                el.addClass('lost');
            }
            this.over = true;
        },
        setDefaults: function(){
            $("#rows").val(defaults.cols);
            $("#cols").val(defaults.rows);
            $("#bombs").val(defaults.bombs);
        },
        start: function(options){
            options = options || {};
            var pat = /\D/;
            var numBombs = $("#bombs").val(), colls = $("#cols").val(), rows = $("#rows").val();
            // add some input valoidation 
            if(pat.test(colls) || pat.test(rows) || pat.test(numBombs)) {
                throw new Error('Use numbers only');
            }
            if (numBombs > colls * rows) {
                throw new Error('Too many bombs');
            }
            
            if(options.skipConfirm || confirm("Are you sure?")) {
                Board.reset(rows, colls, numBombs).draw();
                $('#status').html("Playing").addClass("alert-info").removeClass("alert-success").removeClass("alert-error");
                $("#minesweeper").addClass('active').removeClass('lost');
            }
        }
    };
    
    $(function(){
        
        $("#minesweeper").delegate("td", "click", function(e){
            if(!Game.over) {
                Board.reveal(Board.getCellByEvent(e));
            }
        });
        
        $("#minesweeper").delegate("td", "contextmenu", function(e){
            e.preventDefault();
            if(!Game.over) {
                Board.getCellByEvent(e).mark();
            }
        });
 
        $("#new-game").on('click', function(e){
            e.preventDefault();
            $("form").submit();
        });
        
        $("form").on('submit', function(e){
            e.preventDefault();
            try {
                Game.start();
            }
            catch(ex){
                alert(ex.message);
                Game.setDefaults();
            }
        });
        
        $("#cheat").on('click', function(){
            Board.checkBombs();
            return false;
        });
        
        Game.setDefaults();
        Game.start({skipConfirm: true});
    });
    
}(jQuery);