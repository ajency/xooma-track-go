
    conole.log("ddddddddd");
            var ExampleViewModel = function () {
                var self = this;

                self.popoverBindingHeader = ko.observable('');
                self.popoverBindingHeader2 = ko.observable('');
                self.popoverBindingHeader3 = ko.observable('');
                self.popoverBindingHeader4 = ko.observable('');
                self.popoverBindingHeader5 = ko.observable('');
                self.popoverBindingHeader6 = ko.observable('');
                self.popoverBindingHeader7 = ko.observable('');
                self.popoverBindingHeader8 = ko.observable('');

                self.frameworkToAdd = ko.observable("");
                self.addFramework = function() {
                    self.jsFrameworks.push(self.frameworkToAdd());
                };

                self.removeFramework = function(framework) {
                    self.jsFrameworks.remove(framework);
                };
            };

            $(function(){
                // make code pretty
                window.prettyPrint && prettyPrint();

                var viewModel = new ExampleViewModel();

                ko.applyBindings(viewModel);
            });
        

 
