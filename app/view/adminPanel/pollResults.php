        <div class="row"><h1>Referaty:</h1>
            <?php
            $count = $this->admindao->countLectures();
            $lectureResults = $this->admindao->getLectureResults($count);
            $i = 1;
            foreach ($lectureResults as $result) {
                $fullname = $result["fullname"];
                $title = $result["title"];
                $score = $result["score"];
            ?>
            <hr>
            <div class="row" style="margin-bottom: 2em">
                <div class="col-lg-2"><h1><?php echo $i; ?>. </h1></div>
                <div class="col-lg-2"> <?php echo $score; ?>pkt. </div>
                <div class="col-lg-8">
                    <div class="row">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="row">
                        <?php echo $fullname; ?>
                    </div>
                </div>
            </div>
            <?php   
                $i++;
            }
            ?>
        </div>
        <hr>
        <div class="row" style="margin-top: 2em"><h1>Plakaty:</h1>
            <?php
            $count = $this->admindao->countLectures();
            $posterResults = $this->admindao->getPosterResults($count);
            $i = 1;
            foreach ($posterResults as $result) {
                $fullname = $result["fullname"];
                $title = $result["title"];
                $score = $result["score"];
            ?>
            <hr>
            <div class="row" style="margin-bottom: 2em">
                <div class="col-lg-2"><h1><?php echo $i; ?>. </h1></div>
                <div class="col-lg-2"><?php echo $score; ?>pkt.</div>
                <div class="col-lg-8">
                    <div class="row">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="row">
                        <?php echo $fullname; ?>
                    </div>
                </div>
            </div>
            <?php   
                $i++;
            }
            ?>
        </div>            
