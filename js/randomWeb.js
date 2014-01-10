function randomWeb() {
                        var website = ["http://www.ocw.mit.edu","http://www.gaben.tv","http://www.coursera.org","http://issuu.com/ganavya/docs/panku09","http://www.ubuntu.com"];
                        var randomInt = Math.round(Math.random()*website.length);
                        window.location = website[randomInt];
                }