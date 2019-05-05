define(['core/yui', 'filter_teamwork/popup', 'filter_teamwork/skin', 'core/ajax'], function (Y, popup, skin, Ajax) {
    `use strict`;

    let render = {

        data: '',
        sesskey: M.cfg.sesskey,

        // Set default data.
        setDefaultData: function () {
            let sesskey = this.data.sesskey;
            let courseid = this.data.courseid;
            let activityid = this.data.activityid;
            let moduletype = this.data.moduletype;
            let selectgroupid = this.data.selectgroupid;

            this.data = {
                sesskey: sesskey,
                courseid: courseid,
                activityid: activityid,
                moduletype: moduletype,
                selectgroupid: selectgroupid
            }

        },

        // Open main block.
        mainBlock: function (searchInit) {

            var promises = Ajax.call([{
                methodname: 'render_teamwork_html',
                args: {
                    courseid: this.data.courseid,
                    activityid: this.data.activityid,
                    moduletype: this.data.moduletype,
                    selectgroupid: this.data.selectgroupid
                }
            }]);

            promises[0].done(function (response) {
                let result = JSON.parse(response.result);
                skin.shadow = result.shadow;
                skin.content = result.content;
                skin.show();
                searchInit();
            }).fail(function (ex) {
                popup.error();
            });
        },

        studentList: function () {

            const targetBlock = document.querySelector(`#studentList`);
            var promises = Ajax.call([{
                methodname: 'render_student_list',
                args: {
                    courseid: this.data.courseid,
                    activityid: this.data.activityid,
                    moduletype: this.data.moduletype,
                    selectgroupid: this.data.selectgroupid
                }
            }]);

            promises[0].done(function (response) {
                let result = JSON.parse(response.result);
                targetBlock.innerHTML = result.content;
            }).fail(function (ex) {
                popup.error();
            });
        },

        teamsCard: function () {

            const targetBlock = document.querySelector(`#teamsCard`);
            var promises = Ajax.call([{
                methodname: 'render_teams_card',
                args: {
                    courseid: this.data.courseid,
                    activityid: this.data.activityid,
                    moduletype: this.data.moduletype,
                    selectgroupid: this.data.selectgroupid
                }
            }]);

            promises[0].done(function (response) {
                let result = JSON.parse(response.result);
                targetBlock.innerHTML = result.content;
            }).fail(function (ex) {
                popup.error();
            });
        }

    }

    return render

});
