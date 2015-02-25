<?php echo $this->Html->css(array('posts_fan_preview')); ?>
<div class="postwrapper uploadPost">
    <div class="fansPreview " style="width: 1000px;">
        <div class="fansPreviewHead gradient">
            <span class="postTitle">Upload Image</span>
            <a class="prviewClose" href="javascript:void(0);"></a>
<!--            <span class="brdr"></span>-->
        </div>
         <div class="previewCommon" style="overflow-y: auto">
             <div class="postPreviewPad">
                <form id="" class="Fan newPostForm clearfix">
                     <input type="hidden" name="hcuserImagePath" id="huserImagePath"  val=""/>
                     <input type="hidden" name="huserThumbImagePath" id="huserThumbImagePath"  val=""/>

                      <input type="hidden" name="hcurrentwidth" id="hcurrentwidth"  val=""/>
                       <input type="hidden" name="hcurrentwidth" id="hcurrentwidth"  val=""/>

                        <input type="hidden" name="filePath" id="filePath"  val=""/>
                        <input type="hidden" name="mediaId" id="mediaId"  val=""/>

                     <input type="hidden" name="x1" id="x1"  val=""/>
                     <input type="hidden" name="x2" id="x2"  val=""/>
                     <input type="hidden" name="y1" id="y1"  val=""/>
                     <input type="hidden" name="y2" id="y2"  val=""/>

                     <input type="hidden" name="w" id="w"  val=""/>
                     <input type="hidden" name="h" id="h"  val=""/>


                     <div class="new clearfix" >
                        <p class="clearfix uploadImage">
                            <span id="parent" style="position: relative; display:block;">
                            <label for="title"></label>
                            <img src="" id="thumbnail" class="img_select" alt="Create Thumbnail" />
                            </span>
                        </p>
                         <div class="companyUploadPhoto photo_upload">
                            <img src="" alt="Thumbnail Preview" id="thumbPreview"/>
                        </div>
                        <button value="Save" class="ModalButton buttonMarginLeft savelogo" id="save_thumb"  action= "actionNew" type="button">Save</button>
                        <span style ="margin-left: 11px;display:none" class="error timezoneerror" ></span>

                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var pid = '<?php echo $pid;?>';
</script>
<?php echo $this->Html->script(array('Family/add_media')); ?>