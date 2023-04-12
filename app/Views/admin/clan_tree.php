<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?=base_url('assets/lib/family-chart/family-chart.css')?>"></link>
    <script src="<?=base_url('assets/lib/d3js/d3.js')?>"></script>
    <script src="<?=base_url('assets/lib/family-chart/family-chart.js')?>"></script>
    <section class="section">
        <div class="section-header">
            <h1>Silsilah - <?=$clanName?></h1>
        </div>

        <div class="section-body">
            <style>
                #FamilyChart {
                    height: 70vh;
                }
            </style>
            <div id="FamilyChart" class="f3 ml-2"></div>
        </div>
    </section>

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
            mini_tree: true,
            link_break: true
        });

        view.setCard(Card);
        store.setOnUpdate((props) => view.update(props || {}));
        store.update.tree({ initial: true });

        function data() {
            return <?=json_encode($clanMembers)?>;
        }
    </script>
<?= $this->endSection() ?>