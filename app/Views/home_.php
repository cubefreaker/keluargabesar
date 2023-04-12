<?= $this->extend("layout") ?>
<?= $this->section("content") ?>
    <script src="<?=base_url('assets/lib/familytree/familytree.js')?>"></script>
    <div id="tree"/>
    <script>
        FamilyTree.templates.myTemplate = Object.assign({}, FamilyTree.templates.base);
        FamilyTree.templates.myTemplate.defs = `<style>
                                            .{randId} .bft-edit-form-header, .{randId} .bft-img-button{
                                                background-color: #aeaeae;
                                            }
                                            .{randId}.male .bft-edit-form-header, .{randId}.male .bft-img-button{
                                                background-color: #039BE5;
                                            }        
                                            .{randId}.male div.bft-img-button:hover{
                                                background-color: #F57C00;
                                            }
                                            .{randId}.female .bft-edit-form-header, .{randId}.female .bft-img-button{
                                                background-color: #F57C00;
                                            }        
                                            .{randId}.female div.bft-img-button:hover{
                                                background-color: #039BE5;
                                            }
                                        </style>
                                        <clipPath id="myTemplate_img_0"><rect x="6" y="6" rx="54" ry="54" width="108" height="108"></rect></clipPath>
                                        ${FamilyTree.gradientCircleForDefs('circle', '#aeaeae', 60, 5)}
                                        ${FamilyTree.gradientCircleForDefs('male_circle', '#039BE5', 60, 5)}
                                        ${FamilyTree.gradientCircleForDefs('female_circle', '#F57C00', 60, 5)}`;
        FamilyTree.templates.myTemplate.field_0 = 
            '<text ' + FamilyTree.attr.width + ' ="120" style="font-size: 16px;font-weight:bold;" fill="#666666" x="60" y="145" text-anchor="middle">{val}</text>';
        FamilyTree.templates.myTemplate.node = '<use x="0" y="0" xlink:href="#circle" />';
        FamilyTree.templates.myTemplate.img_0 = 
            '<image preserveAspectRatio="xMidYMid slice" clip-path="url(#myTemplate_img_0)" xlink:href="{val}" x="6" y="6" width="108" height="108"></image>';
        FamilyTree.templates.myTemplate.ripple = {
            radius: 60,
            color: "#e6e6e6",
            rect: null
        };

        FamilyTree.templates.myTemplate.size = [120, 120]
        FamilyTree.templates.myTemplate_male = Object.assign({}, FamilyTree.templates.myTemplate);
        FamilyTree.templates.myTemplate_male.plus =
            '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>'
            + '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>'
            + '<line x1="0" y1="-11" x2="0" y2="11" stroke-width="1" stroke="#aeaeae"></line>';
        FamilyTree.templates.myTemplate_male.minus =
            '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>'
            + '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>';

        FamilyTree.templates.myTemplate_male.node += '<use x="0" y="0" xlink:href="#male_circle" />';
        FamilyTree.templates.myTemplate_male.ripple = {
            radius: 60,
            color: "#039BE5",
            rect: null
        };
        FamilyTree.templates.myTemplate_female = Object.assign({}, FamilyTree.templates.myTemplate);
        FamilyTree.templates.myTemplate_female.plus =
            '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>'
            + '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>'
            + '<line x1="0" y1="-11" x2="0" y2="11" stroke-width="1" stroke="#aeaeae"></line>';
        FamilyTree.templates.myTemplate_female.minus =
            '<circle cx="0" cy="0" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>'
            + '<line x1="-11" y1="0" x2="11" y2="0" stroke-width="1" stroke="#aeaeae"></line>';
        FamilyTree.templates.myTemplate_female.node += '<use x="0" y="0" xlink:href="#female_circle" />';
        FamilyTree.templates.myTemplate_female.ripple = {
            radius: 60,
            color: "#F57C00",
            rect: null
        };

        FamilyTree.templates.myTemplate_female.defs += '<g transform="matrix(0.05,0,0,0.05,-12,-9)" id="heart"><path fill="#D70000" d="M438.482,58.61c-24.7-26.549-59.311-41.655-95.573-41.711c-36.291,0.042-70.938,15.14-95.676,41.694l-8.431,8.909  l-8.431-8.909C181.284,5.762,98.663,2.728,45.832,51.815c-2.341,2.176-4.602,4.436-6.778,6.778 c-52.072,56.166-52.072,142.968,0,199.134l187.358,197.581c6.482,6.843,17.284,7.136,24.127,0.654 c0.224-0.212,0.442-0.43,0.654-0.654l187.29-197.581C490.551,201.567,490.551,114.77,438.482,58.61z"/><g>';
        FamilyTree.templates.myTemplate_male.defs += '<g transform="matrix(0.05,0,0,0.05,-12,-9)" id="heart"><path fill="#D70000" d="M438.482,58.61c-24.7-26.549-59.311-41.655-95.573-41.711c-36.291,0.042-70.938,15.14-95.676,41.694l-8.431,8.909  l-8.431-8.909C181.284,5.762,98.663,2.728,45.832,51.815c-2.341,2.176-4.602,4.436-6.778,6.778 c-52.072,56.166-52.072,142.968,0,199.134l187.358,197.581c6.482,6.843,17.284,7.136,24.127,0.654 c0.224-0.212,0.442-0.43,0.654-0.654l187.29-197.581C490.551,201.567,490.551,114.77,438.482,58.61z"/><g>';

        
        var family = new FamilyTree(document.getElementById("tree"), {
            // mouseScrool: FamilyTree.action.none,
            scaleInitial: FamilyTree.match.height,
            // orientation: FamilyTree.orientation.top,
            template: "myTemplate",
            //mode: "dark",
            menu: {
                pdf: { text: "Export PDF" },
                png: { text: "Export PNG" },
                svg: { text: "Export SVG" },
                csv: { text: "Export CSV" }
            },
            editForm: {
                buttons: {
                    pdf: null,
                    share: null,
                    edit: null,
                }
            },
            nodeBinding: {
                field_0: "name",
                img_0: "photo",
            }
        });

        family.load(<?=json_encode($clanMembers)?>);

        family.on('expcollclick', function (sender, isCollapsing, nodeId) {
            var node = family.getNode(nodeId);
            if (isCollapsing){
                family.expandCollapse(nodeId, [], node.ftChildrenIds)
            }
            else{
                family.expandCollapse(nodeId, node.ftChildrenIds, [])
            }
            return false;
        });

        family.on('render-link', function(sender, args){
            if (args.cnode.ppid != undefined)
                args.html += '<use data-ctrl-ec-id="' + args.node.id + '" xlink:href="#heart" x="' + (args.p.xb) + '" y="' + (args.p.ya ) +'"/>';
            if (args.cnode.isPartner && args.node.partnerSeparation == 30)
                args.html += '<use data-ctrl-ec-id="' + args.node.id + '" xlink:href="#heart" x="' + (args.p.xb) + '" y="' + (args.p.yb) +'"/>';
            
        });

    </script>
<?= $this->endSection() ?>