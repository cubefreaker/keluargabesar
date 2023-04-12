<?= $this->extend("layout") ?>
<?= $this->section("content") ?>
    <script src="<?=base_url('assets/lib/d3js/d3.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/lib/family-chart/family-chart.css')?>"></link>
    <script src="<?=base_url('assets/lib/family-chart/family-chart.js')?>"></script>

    <style>
        .fab-left {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 99;
        }

        .fab-left .btn-fab-left {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        #side-drawer {
            top: 65px;
            height: calc(100vh - 65px);
            width: 200px;  /* Reference: https://forums.envato.com/t/standard-sidebar-width/75633 */
            z-index: 1032;  /* z-index of standard bootstrap navbar is 1030 + 1 offset due to side-drawer-void */
            left: -336px;
            transition: left 0.25s ease;
            overflow-y: scroll;
        }
        #side-drawer-void {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1031;  /* z-index of standard bootstrap navbar is 1030 */
            background: rgba(0,0,0,.6);
        }
    </style>
    
    <div id="FamilyChart"  class="f3"></div>
    
    <div class="fab-left">
        <button type="button" class="btn btn-primary btn-fab-left text-white" onclick="openSideDrawer()"> <i class="fa fa-location-arrow"></i> </button>
    </div>
    <div id="side-drawer" class="position-fixed">
        <div class="h-100 bg-white">
            <div class="section-title mb-0">
                <h4 class="m-0 text-uppercase font-weight-bold">Daftar Isi</h4>
            </div>
            <ul class="list-group" onclick="closeSideDrawer()">
                <li ng-repeat="section in listSection"">
                    <a ng-click="goToSection(section.id)" class="list-group-item list-group-item-action border-0 rounded-0">{{ section.text }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="side-drawer-void" class="position-fixed d-none" onclick="closeSideDrawer()"></div>

    <script>
        function openSideDrawer() {
            document.getElementById("side-drawer").style.left = "0";
            document.getElementById("side-drawer-void").classList.add("d-block");
            document.getElementById("side-drawer-void").classList.remove("d-none");
        }
      
        function closeSideDrawer() {
            document.getElementById("side-drawer").style.left = "-336px";
            document.getElementById("side-drawer-void").classList.add("d-none");
            document.getElementById("side-drawer-void").classList.remove("d-block");
        }
        
        window.openSideDrawer = openSideDrawer;
        window.closeSideDrawer = closeSideDrawer;
    </script>

    <script type="module">
        const store = f3.createStore({
            data: data(),
            node_separation: 220,
            level_separation: 150
        }),
        view = f3.d3AnimationView({
            store,
            cont: document.querySelector("#FamilyChart")
        }),
        Card = f3.elements.Card({
            store,
            svg: view.svg,
            card_dim: {
            w: 200,
            h: 70,
            text_x: 75,
            text_y: 15,
            img_w: 60,
            img_h: 60,
            img_x: 5,
            img_y: 5
            },
            card_display: [
                (d) => d.data["name"] || "",
                (d) => d.data["birthday"] || ""
            ],
            mini_tree: false,
            link_break: false
        });

        view.setCard(Card);
        store.setOnUpdate((props) => view.update(props || {}));
        store.update.tree({ initial: true });

        function data() {
            return <?=json_encode($clanMembers)?>;
        }
    </script>
<?= $this->endSection() ?>